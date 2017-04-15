<?php

namespace Tests\Features;

use App\Models\Reply;
use App\Models\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

class AdminTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    function requires_login()
    {
        $this->visit('/admin')
            ->seePageIs('/login');
    }

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
        $this->loginAsAdmin();

        factory(User::class)->create(['name' => 'Freek Murze']);
        factory(User::class)->create(['name' => 'Frederick Vanbrabant']);

        $this->visit('/admin')
            ->see('Freek Murze')
            ->see('Frederick Vanbrabant');
    }

    /** @test */
    public function admins_can_ban_a_user()
    {
        $this->loginAsAdmin();

        $user = factory(User::class)->create(['name' => 'Freek Murze']);

        $this->put('/admin/users/'.$user->username().'/ban')
            ->assertRedirectedTo('/admin/users/'.$user->username());

        $this->seeInDatabase('users', ['id' => $user->id(), 'is_banned' => true]);
    }

    /** @test */
    public function admins_can_unban_a_user()
    {
        $this->loginAsAdmin();

        $user = factory(User::class)->create(['name' => 'Freek Murze', 'is_banned' => true]);

        $this->put('/admin/users/'.$user->username().'/unban')
            ->assertRedirectedTo('/admin/users/'.$user->username());

        $this->seeInDatabase('users', ['id' => $user->id(), 'is_banned' => false]);
    }

    /** @test */
    public function admins_cannot_ban_other_admins()
    {
        $this->loginAsAdmin();

        $user = factory(User::class)->create(['name' => 'Freek Murze', 'type' => User::ADMIN]);

        $this->put('/admin/users/'.$user->username().'/ban')
            ->assertRedirectedTo('/admin/users/'.$user->username());

        $this->seeInDatabase('users', ['name' => 'Freek Murze']);
    }

    /** @test */
    public function admins_can_delete_a_user()
    {
        $this->loginAsAdmin();

        $user = factory(User::class)->create(['name' => 'Freek Murze']);
        $thread = factory(Thread::class)->create(['author_id' => $user->id()]);
        factory(Reply::class)->create(['replyable_id' => $thread->id()]);
        factory(Reply::class)->create(['author_id' => $user->id()]);

        $this->delete('/admin/users/'.$user->username())
            ->assertRedirectedTo('/admin');

        $this->notSeeInDatabase('users', ['name' => 'Freek Murze']);
        $this->notSeeInDatabase('threads', ['author_id' => $user->id()]);
        $this->notSeeInDatabase('replies', ['replyable_id' => $thread->id()]);
        $this->notSeeInDatabase('replies', ['author_id' => $user->id()]);
    }

    /** @test */
    public function admins_cannot_delete_other_admins()
    {
        $this->loginAsAdmin();

        $user = factory(User::class)->create(['name' => 'Freek Murze', 'type' => User::ADMIN]);

        $this->delete('/admin/users/'.$user->username())
            ->assertRedirectedTo('/admin/users/'.$user->username());

        $this->seeInDatabase('users', ['name' => 'Freek Murze']);
    }
}
