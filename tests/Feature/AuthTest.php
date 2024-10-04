<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\HtmlString;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseTransactions::class);

test('users can register', function () {
    Notification::fake();

    $response = $this->withSession(['githubData' => ['id' => 123, 'username' => 'johndoe']])
        ->post('/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'username' => 'johndoe',
            'rules' => true,
            'terms' => true,
        ]);

    $this->followRedirects($response)
        ->assertSee('John Doe');

    assertLoggedIn();

    $response->assertSessionMissing('githubData');

    Notification::assertSentTo(Auth::user(), VerifyEmail::class);
});

test('registration fails when a required field is not filled in', function () {
    $this->withSession(['githubData' => ['id' => 123]])
        ->post('/register', [])
        ->assertInvalid([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'username' => 'The username field is required.',
            'rules' => 'The rules must be accepted.',
            'terms' => 'The terms must be accepted.',
        ]);
});

test('registration fails with non alpha dash username', function () {
    $this->withSession(['githubData' => ['id' => 123, 'username' => 'johndoe']])
        ->post('/register', [
            'name' => 'Jogn Doe',
            'email' => 'john.doe@example.com',
            'username' => 'john foo',
            'rules' => true,
            'terms' => true,
        ])
        ->assertInvalid([
            'username' => 'The username must only contain letters, numbers, dashes and underscores.',
        ]);
});

test('registration fails with a duplicate github id', function () {
    User::factory()->create(['github_id' => 123, 'github_username' => 'johndoe']);

    $response = $this->withSession(['githubData' => ['id' => 123, 'username' => 'johndoe']])
        ->post('/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'username' => 'johndoe',
            'rules' => true,
            'terms' => true,
        ]);

    $this->followRedirects($response)
        ->assertSee(new HtmlString(
            'We already found a user with the given GitHub account (@johndoe). Would you like to <a href="http://localhost/login">login</a> instead?'
        )
        );
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

    $response->assertRedirect();
});

test('users can login with their username', function () {
    $this->createUser();

    $this->post('login', [
        'username' => 'johndoe',
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
});

test('users can login with their email address', function () {
    $this->createUser();

    $this->post('login', [
        'username' => 'john@example.com',
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
});

test('login fails when a required field is not filled in', function () {
    $this->createUser();

    $response = $this->post('login', []);

    $response->assertInvalid([
        'username' => 'The username field is required.',
        'password' => 'The password field is required.',
    ]);
});

test('login fails when password is incorrect', function () {
    $this->createUser();

    $response = $this->post('login', [
        'username' => 'johndoe',
        'password' => 'invalidpass',
    ]);

    $response->assertInvalid([
        'username' => 'These credentials do not match our records.',
    ]);
});

test('login fails when user is banned', function () {
    $user = $this->createUser(['banned_at' => Carbon::now()]);

    $response = $this->actingAs($user)
        ->post('/login', [
            'username' => 'johndoe',
            'password' => 'password',
        ])
        ->assertRedirect('/');

    $this->followRedirects($response)
        ->assertSee('This account is banned.');
});

test('users can logout', function () {
    $user = $this->login();

    assertLoggedIn();

    $this->actingAs($user)
        ->post('logout')
        ->assertRedirect('/');

    assertLoggedOut();
});

test('users can request a password reset link', function () {
    $this->createUser();

    $this->post('password/email', [
        'email' => 'john@example.com',
    ])
        ->assertSessionHas('status', 'We have emailed your password reset link.');
});

test('users can reset their password', function () {
    $user = $this->createUser();

    // Insert a password reset token into the database.
    $token = $this->app[PasswordBroker::class]->getRepository()->create($user);

    $this->post('/password/reset', [
        'token' => $token,
        'email' => 'john@example.com',
        'password' => 'QFq^$cz#P@MZa5z7',
        'password_confirmation' => 'QFq^$cz#P@MZa5z7',
    ])
        ->assertRedirect();

    $this->actingAs($user)
        ->post('logout');

    assertLoggedOut();

    $this->post('login', [
        'username' => 'johndoe',
        'password' => 'QFq^$cz#P@MZa5z7',
    ]);

    assertLoggedIn();
});

test('users cannot reset their password when it has been compromised in data leaks', function () {
    $user = $this->createUser();

    // Insert a password reset token into the database.
    $token = $this->app[PasswordBroker::class]->getRepository()->create($user);

    $response = $this->post('/password/reset', [
        'token' => $token,
        'email' => 'john@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors([
        'password' => 'The given password has appeared in a data leak. Please choose a different password.',
    ]);
});

test('unverified users cannot create threads', function () {
    $user = $this->login(['email_verified_at' => null]);

    $response = $this->actingAs($user)
        ->get('/forum/create-thread')
        ->assertRedirect();

    $this->followRedirects($response)
        ->assertSee('Before proceeding, please check your email for a verification link.');
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
