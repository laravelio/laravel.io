<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function anyone_can_see_a_user_profile()
    {
        $this->createUser();

        $this->visit('/user/johndoe')
            ->see('John Doe');
    }

    /** @test */
    public function admin_buttons_are_not_shown_to_non_admin_users()
    {
        $this->createUser();

        $this->visit('/user/johndoe')
            ->dontSee('Ban user')
            ->dontSee('Unban user')
            ->dontSee('Delete user');
    }
}
