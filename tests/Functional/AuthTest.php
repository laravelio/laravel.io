<?php
namespace Lio\Tests\Functional;

use Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function users_can_signup()
    {
        $this->visit('/signup')
            ->type('John Doe', 'name')
            ->type('john.doe@example.com', 'email')
            ->type('johndoe', 'username')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->press('Signup')
            ->seePageIs('/dashboard')
            ->see('Welcome John Doe!');

        $this->assertTrue(Auth::check());
    }

    /** @test */
    function signup_fails_when_a_required_field_is_not_filled_in()
    {
        $this->visit('/signup')
            ->press('Signup')
            ->seePageIs('/signup')
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
        $this->be($this->createUser());

        $this->assertTrue(Auth::check());

        $this->visit('/logout')
            ->seePageIs('/');

        $this->assertFalse(Auth::check());
    }
}
