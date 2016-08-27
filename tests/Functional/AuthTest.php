<?php

namespace Tests\Functional;

use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function users_can_register()
    {
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
            ->see('Incorrect login, please try again.');
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
        $this->createUser();

        // Insert a password reset token into the database.
        $this->app['db']->table('password_resets')->insert([
            'email' => 'john@example.com',
            'token' => 'foo-token',
            'created_at' => new Carbon(),
        ]);

        $this->visit('/password/reset/foo-token')
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
}
