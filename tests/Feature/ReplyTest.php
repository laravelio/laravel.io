<?php

namespace Tests\Feature;

use App\User;
use App\Models\Reply;
use App\Models\Thread;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_add_a_reply_to_a_thread()
    {
        factory(Thread::class)->create(['subject' => 'The first thread', 'slug' => 'the-first-thread']);

        $this->login();

        $this->visit('/forum/the-first-thread')
            ->type('The first reply', 'body')
            ->press('Reply')
            ->see('The first thread')
            ->see('The first reply')
            ->see('Reply successfully added!');
    }

    /** @test */
    public function users_can_edit_a_reply()
    {
        $user = $this->createUser();
        $thread = factory(Thread::class)->create(['slug' => 'the-first-thread']);
        factory(Reply::class)->create(['author_id' => $user->id(), 'replyable_id' => $thread->id()]);

        $this->loginAs($user);

        $this->visit('/replies/1/edit')
            ->type('The edited reply', 'body')
            ->press('Update')
            ->seePageIs('/forum/the-first-thread')
            ->see('The edited reply')
            ->see('Reply successfully updated!');
    }

    /** @test */
    public function users_cannot_edit_a_reply_they_do_not_own()
    {
        factory(Reply::class)->create();

        $this->login();

        $this->get('/replies/1/edit')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_delete_a_reply_they_do_not_own()
    {
        factory(Reply::class)->create();

        $this->login();

        $this->delete('/replies/1')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_mark_a_reply_as_the_solution_of_the_thread_if_they_do_not_own_the_thread()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create(['author_id' => $user->id(), 'slug' => 'the-first-thread']);
        $reply = factory(Reply::class)->create(['replyable_id' => $thread->id()]);

        $this->login();

        $this->put('/forum/the-first-thread/mark-solution/'.$reply->id())
            ->assertForbidden();
    }
}
