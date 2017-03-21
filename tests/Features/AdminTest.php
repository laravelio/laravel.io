<?php

namespace Tests\Features;

use App\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;
use Tests\RequiresLogin;

class AdminTest extends BrowserKitTestCase
{
    use DatabaseMigrations, RequiresLogin;

    /**
     * @var string
     */
    protected $uri = '/admin';

    /** @test */
    public function normal_users_cannot_visit_the_admin_section()
    {
        $this->login();

        $this->get('/admin')
            ->assertForbidden();
    }

    /** @test */
    public function admins_can_see_the_users_overview()
    {
        $this->login(['type' => User::ADMIN]);

        $this->create(User::class, ['name' => 'Freek Murze']);
        $this->create(User::class, ['name' => 'Frederick Vanbrabant']);

        $this->visit('/admin')
            ->see('Freek Murze')
            ->see('Frederick Vanbrabant');
    }
}
