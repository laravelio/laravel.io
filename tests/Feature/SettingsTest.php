<?php

use App\Models\User;
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

// Helpers
function assertPasswordWasHashedAndSaved(): void
{
    expect(Hash::check('QFq^$cz#P@MZa5z7', Auth::user()->getAuthPassword()))->toBeTrue();
}
