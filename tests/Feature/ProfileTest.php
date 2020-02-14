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
    public function admin_buttons_are_not_shown_to_logged_out_users()
    {
        $this->createUser();

        $this->visit('/user/johndoe')
            ->dontSee('Ban user')
            ->dontSee('Unban user')
            ->dontSee('Delete user');
    }

    /** @test */
    public function admin_buttons_are_not_shown_to_non_admin_users()
    {
        $this->login();
        
        $this->visit('/user/johndoe')
            ->dontSee('Ban user')
            ->dontSee('Unban user')
            ->dontSee('Delete user');
    }

    /** @test */
    public function admin_buttons_are_shown_to_admin_users()
    {
        $this->createUser([
            'username' => 'janedoe',
            'email' => 'jane@example.com'
        ]);
        $this->loginAsAdmin();
        
        $this->visit('/user/janedoe')
            ->see('Ban user')
            ->see('Delete user');
    }

    /** @test */
    public function delete_button_is_not_shown_to_moderators()
    {
        $this->createUser([
            'username' => 'janedoe',
            'email' => 'jane@example.com'
        ]);
        $this->loginAsModerator();
        
        $this->visit('/user/janedoe')
            ->see('Ban user')
            ->dontSee('Delete user');
    }
}
