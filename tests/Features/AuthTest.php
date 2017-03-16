<?php

namespace Tests\Features;

use App\Mail\ConfirmEmailAddress;
use App\Users\UserWasRegistered;
use Auth;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mail;
use Tests\BrowserKitTestCase;

class AuthTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    function users_can_register()
    {
        Mail::fake();

        $this->visit('/register')
            ->type('John Doe', 'name')
            ->type('john.doe@example.com', 'email')
            ->type('johndoe', 'username')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/dashboard')
            ->see('Welcome John Doe!');

        $this->assertTrue(Auth::check());

        Mail::assertSent(ConfirmEmailAddress::class);
    }

    /** @test */
    function registration_fails_when_a_required_field_is_not_filled_in()
    {
        $this->visit('/register')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The username field is required.')
            ->see('The password field is required.');
    }

    /** @test */
    function users_can_resend_the_email_confirmation()
    {
        $this->login(['confirmed' => false]);

        $this->visit('/email-address-confirmation')
            ->seePageIs('/dashboard')
            ->see('Email address confirmation sent to john@example.com');
    }

    /** @test */
    function users_do_not_need_to_confirm_their_email_address_twice()
    {
        $this->login();

        $this->visit('/email-address-confirmation')
            ->seePageIs('/dashboard')
            ->see('Your email address is already confirmed.');
    }

    /** @test */
    function users_can_confirm_their_email_address()
    {
        $user = $this->createUser(['confirmed' => false, 'confirmation_code' => 'testcode']);

        $this->visit('/email-address-confirmation/john@example.com/testcode')
            ->seePageIs('/')
            ->see('Your email address was successfully confirmed.');

        $this->seeInDatabase('users', ['id' => $user->id(), 'confirmed' => true]);
    }

    /** @test */
    function users_get_a_message_when_a_confirmation_code_was_not_found()
    {
        $this->createUser(['confirmed' => false]);

        $this->visit('/email-address-confirmation/john@example.com/testcode')
            ->seePageIs('/')
            ->see('We could not confirm your email address. The given email address and code did not match.');
    }

    /** @test */
    function users_can_login()
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
    function login_fails_when_a_required_field_is_not_filled_in()
    {
        $this->createUser();

        $this->visit('/login')
            ->press('Login')
            ->seePageIs('/login')
            ->see('The username field is required.')
            ->see('The password field is required.');
    }

    /** @test */
    function login_fails_when_password_is_incorrect()
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
    function login_fails_when_user_is_banned()
    {
        $this->createUser(['is_banned' => true]);

        $this->visit('/login')
            ->type('johndoe', 'username')
            ->type('password', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->see('This account is banned.');
    }

    /** @test */
    function users_can_logout()
    {
        $this->login();

        $this->assertTrue(Auth::check());

        $this->visit('/logout')
            ->seePageIs('/');

        $this->assertFalse(Auth::check());
    }

    /** @test */
    function users_can_request_a_password_reset_link()
    {
        $this->createUser();

        $this->visit('/password/reset')
            ->type('john@example.com', 'email')
            ->press('Send Password Reset Link')
            ->see('We have e-mailed your password reset link!');
    }

    /** @test */
    function users_can_reset_their_password()
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
    function unconfirmed_users_cannot_create_threads()
    {
        $this->login(['confirmed' => false]);

        $this->visit('/forum/create-thread')
            ->see('Please confirm your email address first.');
    }
}
