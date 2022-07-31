<?php

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('requires login', function () {
    $this->visit('/settings')
        ->seePageIs('/login');
});

test('users can update their profile', function () {
    $this->login();

    $this->visit('/settings')
        ->submitForm('Update Profile', [
            'name' => 'Freek Murze',
            'email' => 'freek@example.com',
            'username' => 'freekmurze',
            'twitter' => 'freektwitter',
            'website' => 'https://laravel.io',
            'bio' => 'My bio',
        ])
        ->seePageIs('/settings')
        ->see('Freek Murze')
        ->see('freekmurze')
        ->see('freektwitter')
        ->see('Settings successfully saved!')
        ->see('My bio');
});

test('users cannot choose duplicate usernames or email addresses', function () {
    $this->createUser(['email' => 'freek@example.com', 'username' => 'freekmurze']);

    $this->login();

    $this->visit('/settings')
        ->submitForm('Update Profile', [
            'name' => 'Freek Murze',
            'email' => 'freek@example.com',
            'username' => 'freekmurze',
        ])
        ->seePageIs('/settings')
        ->see('Something went wrong. Please review the fields below.')
        ->see('The email has already been taken.')
        ->see('The username has already been taken.');
});

test('users can delete their account', function () {
    $this->login(['name' => 'Freek Murze']);

    $this->delete('/settings')
        ->assertRedirectedTo('/');

    $this->notSeeInDatabase('users', ['name' => 'Freek Murze']);
});

test('users cannot delete their account', function () {
    $this->loginAsAdmin();

    $this->visit('/settings')
        ->dontSee('Delete Account');
});

test('users can update their password', function () {
    $this->login();

    $this->visit('/settings')
        ->submitForm('Update Password', [
            'current_password' => 'password',
            'password' => 'QFq^$cz#P@MZa5z7',
            'password_confirmation' => 'QFq^$cz#P@MZa5z7',
        ])
        ->seePageIs('/settings')
        ->see('Password successfully changed!');

    assertPasswordWasHashedAndSaved();
});

test('current password is required when updating your password', function () {
    $this->login();

    $this->visit('/settings')
        ->submitForm('Update Password', [
            'password' => 'QFq^$cz#P@MZa5z7',
            'password_confirmation' => 'QFq^$cz#P@MZa5z7',
        ])
        ->seePageIs('/settings')
        ->see('Something went wrong. Please review the fields below.')
        ->see('The current password field is required.');
});

test('users cannot update their password when it has been compromised in data leaks', function () {
    $this->login();

    $this->visit('/settings')
        ->submitForm('Update Password', [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ])
        ->seePageIs('/settings')
        ->see('Something went wrong. Please review the fields below.')
        ->see('The given password has appeared in a data leak. Please choose a different password.');
});

test('users can set their password when they have none set yet', function () {
    $user = User::factory()->passwordless()->create();

    $this->loginAs($user);

    $this->visit('/settings')
        ->submitForm('Update Password', [
            'password' => 'QFq^$cz#P@MZa5z7',
            'password_confirmation' => 'QFq^$cz#P@MZa5z7',
        ])
        ->seePageIs('/settings')
        ->see('Password successfully changed!');

    assertPasswordWasHashedAndSaved();
});

test('twitter is optional', function () {
    $user = $this->createUser(['email' => 'freek@example.com', 'username' => 'freekmurze', 'twitter' => 'freektwitter']);

    $this->loginAs($user);

    $this->visit('/settings')
        ->submitForm('Update Profile', [
            'name' => 'Freek Murze',
            'email' => 'freek@example.com',
            'username' => 'freekmurze',
            'twitter' => '',
        ])
        ->seePageIs('/settings')
        ->dontSee('freektwitter');

    expect($user->fresh()->twitter())->toBeEmpty();
});

test('website is optional', function () {
    $user = $this->createUser(['email' => 'freek@example.com', 'username' => 'freekmurze', 'twitter' => 'freektwitter', 'website' => 'https://laravel.io']);

    $this->loginAs($user);

    $this->visit('/settings')
        ->submitForm('Update Profile', [
            'name' => 'Freek Murze',
            'email' => 'freek@example.com',
            'username' => 'freekmurze',
            'twitter' => 'freektwitter',
            'website' => '',
        ])
        ->seePageIs('/settings')
        ->dontSee('https://laravel.io');

    expect($user->fresh()->website())->toBeEmpty();
});

test('users can generate API tokens', function () {
    $user = $this->createUser();

    $this->loginAs($user);

    $this->visit('/settings')
        ->submitForm('Generate New Token', [
            'token_name' => 'My API Token',
        ])
        ->seePageIs('/settings')
        ->see('API token created! Please copy the following token as it will not be shown again:');

    expect($user->refresh()->tokens)->toHaveCount(1);
});

test('users can delete API tokens', function () {
    $user = $this->createUser();
    $token = $user->createToken('My API Token');

    $this->loginAs($user);

    $this->visit('/settings')
        ->submitForm('Delete Token', [
            'id' => $token->accessToken->getKey(),
        ])
        ->seePageIs('/settings')
        ->see('API token successfully removed.');

    expect($user->refresh()->tokens)->toBeEmpty();
});

test('a user cannot delete another user\'s API token', function () {
    $joe = UserFactory::new()->create();
    $token = $joe->createToken('Joe\'s API Token');

    $adam = $this->createUser();
    $adam->createToken('Adam\'s API Token');
    $this->loginAs($adam);

    $this->visit('/settings')
        ->submitForm('Delete Token', [
            'id' => $token->accessToken->getKey(),
        ])
        ->seePageIs('/settings');

    expect($joe->refresh()->tokens)->toHaveCount(1);
});

// Helpers
function assertPasswordWasHashedAndSaved(): void
{
    expect(Hash::check('QFq^$cz#P@MZa5z7', Auth::user()->getAuthPassword()))->toBeTrue();
}
