<?php

namespace Tests\Feature;

use Auth;
use Mail;
use Carbon\Carbon;
use Tests\BrowserKitTestCase;
use App\Mail\EmailConfirmation;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_register()
    {
        Mail::fake();

        session(['githubData' => ['id' => 123, 'username' => 'johndoe']]);

        $this->visit('/register')
            ->type('John Doe', 'name')
            ->type('john.doe@example.com', 'email')
            ->type('johndoe', 'username')
            ->type('123', 'github_id')
            ->type('johndoe', 'github_username')
            ->check('rules')
            ->press('Register')
            ->seePageIs('/dashboard')
            ->see('Welcome John Doe!');

        $this->assertLoggedIn();

        Mail::assertSent(EmailConfirmation::class);
    }

    /** @test */
    public function registration_fails_when_a_required_field_is_not_filled_in()
    {
        session(['githubData' => ['id' => 123]]);

        $this->visit('/register')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The username field is required.')
            ->see('The rules must be accepted.');
    }

    /** @test */
    public function users_can_resend_the_email_confirmation()
    {
        $this->login(['confirmed' => false]);

        $this->visit('/email-confirmation')
            ->seePageIs('/dashboard')
            ->see('Email confirmation sent to john@example.com');
    }

    /** @test */
    public function users_do_not_need_to_confirm_their_email_address_twice()
    {
        $this->login();

        $this->visit('/email-confirmation')
            ->seePageIs('/dashboard')
            ->see('Your email address is already confirmed.');
    }

    /** @test */
    public function users_can_confirm_their_email_address()
    {
        $user = $this->createUser(['confirmed' => false, 'confirmation_code' => 'testcode']);

        $this->visit('/email-confirmation/john@example.com/testcode')
            ->seePageIs('/')
            ->see('Your email address was successfully confirmed.');

        $this->seeInDatabase('users', ['id' => $user->id(), 'confirmed' => true]);
    }

    /** @test */
    public function users_get_a_message_when_a_confirmation_code_was_not_found()
    {
        $this->createUser(['confirmed' => false]);

        $this->visit('/email-confirmation/john@example.com/testcode')
            ->seePageIs('/')
            ->see('We could not confirm your email address. The given email address and code did not match.');
    }

    /** @test */
    public function users_can_login()
    {
        $this->createUser();

        $this->visit('/login')
            ->type('johndoe', 'username')
            ->type('password', 'password')
            ->press('Login')
            ->seePageIs('/dashboard')
            ->see('Welcome John Doe!');
    }

    /** @test */
    public function login_fails_when_a_required_field_is_not_filled_in()
    {
        $this->createUser();

        $this->visit('/login')
            ->press('Login')
            ->seePageIs('/login')
            ->see('The username field is required.')
            ->see('The password field is required.');
    }

    /** @test */
    public function login_fails_when_password_is_incorrect()
    {
        $this->createUser();

        $this->visit('/login')
            ->type('johndoe', 'username')
            ->type('invalidpass', 'password')
            ->press('Login')
            ->seePageIs('/login')
            ->see('These credentials do not match our records.');
    }

    /** @test */
    public function login_fails_when_user_is_banned()
    {
        $this->createUser(['banned_at' => Carbon::now()]);

        $this->visit('/login')
            ->type('johndoe', 'username')
            ->type('password', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->see('This account is banned.');
    }

    /** @test */
    public function users_can_logout()
    {
        $this->login();

        $this->assertLoggedIn();

        $this->visit('/logout')
            ->seePageIs('/');

        $this->assertLoggedOut();
    }

    /** @test */
    public function users_can_request_a_password_reset_link()
    {
        $this->createUser();

        $this->visit('/password/reset')
            ->type('john@example.com', 'email')
            ->press('Send Password Reset Link')
            ->see('We have e-mailed your password reset link!');
    }

    /** @test */
    public function users_can_reset_their_password()
    {
        $user = $this->createUser();

        // Insert a password reset token into the database.
        $token = $this->app[PasswordBroker::class]->getRepository()->create($user);

        $this->visit('/password/reset/'.$token)
            ->type('john@example.com', 'email')
            ->type('foopassword', 'password')
            ->type('foopassword', 'password_confirmation')
            ->press('Reset Password')
            ->seePageIs('/dashboard')
            ->visit('/logout')
            ->visit('/login')
            ->type('johndoe', 'username')
            ->type('foopassword', 'password')
            ->press('Login')
            ->seePageIs('/dashboard');
    }

    /** @test */
    public function unconfirmed_users_cannot_create_threads()
    {
        $this->login(['confirmed' => false]);

        $this->visit('/forum/create-thread')
            ->see('Please confirm your email address first.');
    }

    private function assertLoggedIn()
    {
        $this->assertTrue(Auth::check());
    }

    private function assertLoggedOut()
    {
        $this->assertFalse(Auth::check());
    }
}
