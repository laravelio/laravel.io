<?php

use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('users can register', function () {
    Event::fake();

    session(['githubData' => ['id' => 123, 'username' => 'johndoe']]);

    $this->visit('/register')
        ->type('John Doe', 'name')
        ->type('john.doe@example.com', 'email')
        ->type('johndoe', 'username')
        ->type('123', 'github_id')
        ->type('johndoe', 'github_username')
        ->check('rules')
        ->check('terms')
        ->press('Register')
        ->seePageIs('/user/johndoe')
        ->see('John Doe');

    assertLoggedIn();

    Event::assertDispatched(Registered::class);
});

test('registration fails when a required field is not filled in', function () {
    session(['githubData' => ['id' => 123]]);

    $this->visit('/register')
        ->press('Register')
        ->seePageIs('/register')
        ->see('The name field is required.')
        ->see('The email field is required.')
        ->see('The username field is required.')
        ->see('The rules must be accepted.');
});

test('registration fails with non alpha dash username', function () {
    session(['githubData' => ['id' => 123, 'username' => 'johndoe']]);

    $this->visit('/register')
        ->type('John Doe', 'name')
        ->type('john.doe@example.com', 'email')
        ->type('john foo', 'username')
        ->type('123', 'github_id')
        ->type('johndoe', 'github_username')
        ->check('rules')
        ->check('terms')
        ->press('Register')
        ->seePageIs('/register')
        ->see('The username must only contain letters, numbers, dashes and underscores.');
});

test('users can resend the email verification', function () {
    $this->login(['email_verified_at' => null]);

    $this->post('/email/resend')
        ->assertSessionHas('success', 'Email verification sent to john@example.com. You can change your email address in your profile settings.');
});

test('users do not need to verify their email address twice', function () {
    $this->login();

    $response = $this->post('/email/resend');

    $response->assertSessionHas('error', 'Your email address is already verified.');
    $response->followRedirects()
        ->seePageIs('/user/johndoe');
});

test('users can login', function () {
    $this->createUser();

    $this->visit('/login')
        ->type('johndoe', 'username')
        ->type('password', 'password')
        ->press('Login')
        ->seePageIs('/user/johndoe')
        ->see('John Doe');
});

test('login fails when a required field is not filled in', function () {
    $this->createUser();

    $this->visit('/login')
        ->press('Login')
        ->seePageIs('/login')
        ->see('The username field is required.')
        ->see('The password field is required.');
});

test('login fails when password is incorrect', function () {
    $this->createUser();

    $this->visit('/login')
        ->type('johndoe', 'username')
        ->type('invalidpass', 'password')
        ->press('Login')
        ->seePageIs('/login')
        ->see('These credentials do not match our records.');
});

test('login fails when user is banned', function () {
    $this->createUser(['banned_at' => Carbon::now()]);

    $this->visit('/login')
        ->type('johndoe', 'username')
        ->type('password', 'password')
        ->press('Login')
        ->seePageIs('/')
        ->see('This account is banned.');
});

test('users can logout', function () {
    $this->login();

    assertLoggedIn();

    $this->visit('/')
        ->press('Sign out')
        ->seePageIs('/');

    assertLoggedOut();
});

test('users can request a password reset link', function () {
    $this->createUser();

    $this->visit('/password/reset')
        ->type('john@example.com', 'email')
        ->press('Send Password Reset Link')
        ->see('We have emailed your password reset link!');
});

test('users can reset their password', function () {
    $user = $this->createUser();

    // Insert a password reset token into the database.
    $token = $this->app[PasswordBroker::class]->getRepository()->create($user);

    $this->visit('/password/reset/'.$token)
        ->type('john@example.com', 'email')
        ->type('QFq^$cz#P@MZa5z7', 'password')
        ->type('QFq^$cz#P@MZa5z7', 'password_confirmation')
        ->press('Reset Password')
        ->seePageIs('/user/johndoe')
        ->press('Sign out')
        ->visit('/login')
        ->type('johndoe', 'username')
        ->type('QFq^$cz#P@MZa5z7', 'password')
        ->press('Login')
        ->seePageIs('/user/johndoe');
});

test('users cannot reset their password when it has been compromised in data leaks', function () {
    $user = $this->createUser();

    // Insert a password reset token into the database.
    $token = $this->app[PasswordBroker::class]->getRepository()->create($user);

    $this->visit('/password/reset/'.$token)
        ->type('john@example.com', 'email')
        ->type('password', 'password')
        ->type('password', 'password_confirmation')
        ->press('Reset Password')
        ->seePageIs('/password/reset/'.$token)
        ->see('The given password has appeared in a data leak. Please choose a different password.');
});

test('unverified users cannot create threads', function () {
    $this->login(['email_verified_at' => null]);

    $this->visit('/forum/create-thread')
        ->see('Before proceeding, please check your email for a verification link.');
});

// Helpers
function assertLoggedIn(): void
{
    expect(Auth::check())->toBeTrue();
}

function assertLoggedOut(): void
{
    expect(Auth::check())->toBeFalse();
}
