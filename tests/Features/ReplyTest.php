<?php

namespace Tests\Features;

use App\Models\Thread;
use App\Replies\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

class ReplyTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_add_a_reply_to_a_thread()
    {
        $this->login();

        factory(Thread::class)->create(['subject' => 'The first thread', 'slug' => 'the-first-thread']);

        $this->visit('/forum/the-first-thread')
            ->type('The first reply', 'body')
            ->press('Reply')
            ->see('The first thread')
            ->see('The first reply')
            ->see('Reply successfully added!');
    }

    /** @test */
    function we_can_edit_a_reply()
    {
        $user = $this->login();

        $thread = factory(Thread::class)->create(['slug' => 'the-first-thread']);
        factory(Reply::class)->create([
            'body' => 'The first reply',
            'author_id' => $user->id(),
            'replyable_id' => $thread->id(),
        ]);

        $this->visit('/replies/1/edit')
            ->type('The edited reply', 'body')
            ->press('Update')
            ->seePageIs('/forum/the-first-thread')
            ->see('The edited reply')
            ->see('Reply successfully updated!');
    }

    /** @test */
    function we_cannot_edit_a_reply_we_do_not_own()
    {
        $this->login();

        factory(Reply::class)->create(['body' => 'The first reply']);

        $this->get('/replies/1/edit')
            ->assertForbidden();
    }

    /** @test */
    function we_cannot_delete_a_reply_we_do_not_own()
    {
        $this->login();

        factory(Reply::class)->create(['body' => 'The first reply']);

        $this->delete('/replies/1')
            ->assertForbidden();
    }

    /** @test */
    function we_cannot_mark_a_reply_as_the_solution_of_the_thread_if_we_do_not_own_the_thread()
    {
        $this->login();

        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create([
            'author_id' => $user->id(),
            'subject' => 'The first thread',
            'slug' => 'the-first-thread',
        ]);
        $reply = factory(Reply::class)->create(['body' => 'The first reply', 'replyable_id' => $thread->id()]);

        $this->put('/forum/the-first-thread/mark-solution/'.$reply->id())
            ->assertForbidden();
    }
}
