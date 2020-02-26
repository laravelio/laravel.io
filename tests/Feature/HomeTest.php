<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_see_the_homepage()
    {
        $this->visit('/')
            ->see('Laravel.io')
            ->see('The Laravel Community Portal');
    }

    /** @test */
    public function users_can_see_a_login_and_registration_link_when_logged_out()
    {
        $this->visit('/')
            ->seeLink('Login')
            ->seeLink('Register')
            ->dontSeeLink('Sign out');
    }

    /** @test */
    public function users_can_see_a_logout_button_when_logged_in()
    {
        $this->login();

        $this->visit('/')
            ->seeLink('Sign out')
            ->dontSeeLink('Login')
            ->dontSeeLink('Register')
            ->seeLink('Dashboard', '/dashboard');
    }
}
