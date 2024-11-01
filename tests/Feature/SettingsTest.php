<?php

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('requires login', function () {
    $this->get('/settings')
        ->assertRedirect('/login');
});

test('users can update their profile', function () {
    $user = $this->login();

    $response = $this->actingAs($user)
        ->put('/settings', [
            'name' => 'Freek Murze',
            'email' => 'freek@example.com',
            'username' => 'freekmurze',
            'twitter' => 'freektwitter',
            'website' => 'https://laravel.io',
            'bio' => 'My bio',
        ])
        ->assertRedirect('/settings');

    $this->followRedirects($response)
        ->assertSee('Freek Murze')
        ->assertSee('freekmurze')
        ->assertSee('freektwitter')
        ->assertSee('Settings successfully saved!')
        ->assertSee('My bio');
});

test('users cannot choose duplicate usernames or email addresses', function () {
    $this->createUser(['email' => 'freek@example.com', 'username' => 'freekmurze']);

    $user = $this->login();

    $response = $this->actingAs($user)
        ->put('/settings', [
            'name' => 'Freek Murze',
            'email' => 'freek@example.com',
            'username' => 'freekmurze',
        ])
        ->assertInvalid([
            'username' => 'The username has already been taken.',
            'email' => 'The email has already been taken.',
        ]);

    $this->followRedirects($response)
        ->assertSee('Something went wrong. Please review the fields below.');
});

test('users can delete their account', function () {
    $this->login(['name' => 'Freek Murze']);

    $this->delete('/settings')
        ->assertRedirect('/');

    $this->assertDatabaseMissing('users', ['name' => 'Freek Murze']);
});

test('users cannot delete their account', function () {
    $this->loginAsAdmin();

    $this->get('/settings')
        ->assertDontSee('Delete Account');
});

test('users can update their password', function () {
    $user = $this->login();

    $response = $this->actingAs($user)
        ->put('settings/password', [
            'current_password' => 'password',
            'password' => 'QFq^$cz#P@MZa5z7',
            'password_confirmation' => 'QFq^$cz#P@MZa5z7',
        ])
        ->assertRedirect('/settings');

    $this->followRedirects($response)
        ->assertSee('Password successfully changed!');

    assertPasswordWasHashedAndSaved();
});

test('current password is required when updating your password', function () {
    $user = $this->login();

    $response = $this->actingAs($user)
        ->put('settings/password', [
            'password' => 'QFq^$cz#P@MZa5z7',
            'password_confirmation' => 'QFq^$cz#P@MZa5z7',
        ])
        ->assertInvalid([
            'current_password' => 'The current password field is required.',
        ]);

    $this->followRedirects($response)
        ->assertSee('Something went wrong. Please review the fields below.');
});

test('users cannot update their password when it has been compromised in data leaks', function () {
    $user = $this->login();

    // Http::fake([
    //     'api.pwnedpasswords.com/*' => Http::response('newpassword:3600895'),
    // ]);

    $response = $this->actingAs($user)
        ->put('settings/password', [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ])
        ->assertInvalid([
            'password' => 'The given password has appeared in a data leak. Please choose a different password.',
        ]);

    $this->followRedirects($response)
        ->assertSee('Something went wrong. Please review the fields below.');
});

test('users can set their password when they have none set yet', function () {
    $user = User::factory()->passwordless()->create();

    $this->loginAs($user);

    $response = $this->actingAs($user)
        ->put('settings/password', [
            'password' => 'QFq^$cz#P@MZa5z7',
            'password_confirmation' => 'QFq^$cz#P@MZa5z7',
        ])
        ->assertRedirect('/settings');

    $this->followRedirects($response)
        ->assertSee('Password successfully changed!');

    assertPasswordWasHashedAndSaved();
});

test('twitter is optional', function () {
    $user = $this->createUser(['email' => 'freek@example.com', 'username' => 'freekmurze', 'twitter' => 'freektwitter']);

    $this->loginAs($user);

    $response = $this->actingAs($user)
        ->put('/settings', [
            'name' => 'Freek Murze',
            'email' => 'freek@example.com',
            'username' => 'freekmurze',
            'twitter' => '',
        ])
        ->assertRedirect('/settings');

    $this->followRedirects($response)
        ->assertDontSee('freektwitter');

    expect($user->fresh()->twitter())->toBeEmpty();
});

test('website is optional', function () {
    $user = $this->createUser(['email' => 'freek@example.com', 'username' => 'freekmurze', 'twitter' => 'freektwitter', 'website' => 'https://laravel.io']);

    $this->loginAs($user);

    $response = $this->actingAs($user)
        ->put('/settings', [
            'name' => 'Freek Murze',
            'email' => 'freek@example.com',
            'username' => 'freekmurze',
            'twitter' => 'freektwitter',
            'website' => '',
        ])
        ->assertRedirect('/settings');

    $this->followRedirects($response)
        ->assertDontSee('https://laravel.io');

    expect($user->fresh()->website())->toBeEmpty();
});

test('users can generate API tokens', function () {
    $user = $this->createUser();

    $this->loginAs($user);

    $response = $this->actingAs($user)
        ->post('/settings/api-tokens', [
            'token_name' => 'My API Token',
        ])
        ->assertRedirect('/settings');

    $this->followRedirects($response)
        ->assertSee('API token created! Please copy the following token as it will not be shown again:');

    expect($user->refresh()->tokens)->toHaveCount(1);
});

test('users can delete API tokens', function () {
    $user = $this->createUser();
    $token = $user->createToken('My API Token');

    $this->loginAs($user);

    $response = $this->actingAs($user)
        ->delete('/settings/api-tokens', [
            'id' => $token->accessToken->getKey(),
        ])
        ->assertRedirect('/settings');

    $this->followRedirects($response)
        ->assertSee('API token successfully removed.');

    expect($user->refresh()->tokens)->toBeEmpty();
});

test('a user cannot delete another user\'s API token', function () {
    $joe = UserFactory::new()->create();
    $token = $joe->createToken('Joe\'s API Token');

    $adam = $this->createUser();
    $adam->createToken('Adam\'s API Token');
    $this->loginAs($adam);

    $this->actingAs($adam)
        ->delete('/settings/api-tokens', [
            'id' => $token->accessToken->getKey(),
        ])
        ->assertRedirect('/settings');

    expect($joe->refresh()->tokens)->toHaveCount(1);
});

// Helpers
function assertPasswordWasHashedAndSaved(): void
{
    expect(Hash::check('QFq^$cz#P@MZa5z7', Auth::user()->getAuthPassword()))->toBeTrue();
}
