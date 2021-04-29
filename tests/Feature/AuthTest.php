<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class AuthTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_register()
    {
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
            ->seePageIs('/dashboard')
            ->see('@johndoe');

        $this->assertLoggedIn();

        Event::assertDispatched(Registered::class);
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
    public function registration_fails_with_non_alpha_dash_username()
    {
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
            ->see('The username may only contain letters, numbers, dashes and underscores.');
    }

    /** @test */
    public function users_can_resend_the_email_verification()
    {
        $this->login(['email_verified_at' => null]);

        $this->post('/email/resend')
            ->assertSessionHas('success', 'Email verification sent to john@example.com. You can change your email address in your profile settings.');
    }

    /** @test */
    public function users_do_not_need_to_verify_their_email_address_twice()
    {
        $this->login();

        $this->post('/email/resend')
            ->assertRedirectedTo('/dashboard')
            ->assertSessionHas('error', 'Your email address is already verified.');
    }

    // /** @test */
    // public function users_can_verify_their_email_address()
    // {
    //     $user = $this->login(['email_verified_at' => null]);
    //
    //     $id = $user->getKey();
    //     $hash = sha1('john@example.com');
    //
    //     $this->get("/email/verify/$id/$hash")
    //         ->see('Your email address was successfully verified.');
    //
    //     $this->assertTrue($user->refresh()->hasVerifiedEmail());
    // }

    // /** @test */
    // public function users_get_a_message_when_an_invalid_has_is_provided()
    // {
    //     $this->createUser(['email_verified_at' => null]);
    //
    //     $this->visit('/email/verify/john@example.com/incorrect')
    //         ->seePageIs('/')
    //         ->see('We could not verify your email address. The given email address and code did not match.');
    // }

    /** @test */
    public function users_can_login()
    {
        $this->createUser();

        $this->visit('/login')
            ->type('johndoe', 'username')
            ->type('password', 'password')
            ->press('Login')
            ->seePageIs('/dashboard')
            ->see('@johndoe');
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
    public function users_cannot_reset_their_password_when_it_has_been_compromised_in_data_leaks()
    {
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
    }

    /** @test */
    public function unverified_users_cannot_create_threads()
    {
        $this->login(['email_verified_at' => null]);

        $this->visit('/forum/create-thread')
            ->see('Before proceeding, please check your email for a verification link.');
    }

    private function assertLoggedIn(): void
    {
        $this->assertTrue(Auth::check());
    }

    private function assertLoggedOut(): void
    {
        $this->assertFalse(Auth::check());
    }
}
