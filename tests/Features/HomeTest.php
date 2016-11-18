<?php

namespace Tests\Features;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function users_can_see_the_homepage()
    {
        $this->visit('/')
            ->see('Laravel.io')
            ->see('The Laravel Community Portal');
    }

    /** @test */
    function users_can_see_a_login_and_registration_link_when_logged_out()
    {
        $this->visit('/')
            ->seeLink('Login')
            ->seeLink('Register')
            ->dontSeeLink('Logout');
    }

    /** @test */
    function users_can_see_a_logout_button_when_logged_in()
    {
        $this->login();

        $this->visit('/')
            ->seeLink('Logout')
            ->dontSeeLink('Login')
            ->dontSeeLink('Register')
            ->seeLink('Dashboard', '/dashboard');
    }
}
