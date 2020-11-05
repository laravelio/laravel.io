<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_add_a_reply_to_a_thread()
    {
        $thread = Thread::factory()->create(['subject' => 'The first thread', 'slug' => 'the-first-thread']);

        $this->login();

        $this->post('/replies', [
            'body' => 'The first reply',
            'replyable_id' => $thread->id,
            'replyable_type' => Thread::TABLE,
        ])
            ->assertSessionHas('success', 'Reply successfully added!');
    }

    /** @test */
    public function users_can_edit_a_reply()
    {
        $user = $this->createUser();
        $thread = Thread::factory()->create(['slug' => 'the-first-thread']);
        Reply::factory()->create(['author_id' => $user->id(), 'replyable_id' => $thread->id()]);

        $this->loginAs($user);

        $this->put('/replies/1', [
            'body' => 'The edited reply',
        ])
            ->assertRedirectedTo('/forum/the-first-thread')
            ->assertSessionHas('success', 'Reply successfully updated!');
    }

    /** @test */
    public function users_cannot_edit_a_reply_they_do_not_own()
    {
        Reply::factory()->create();

        $this->login();

        $this->get('/replies/1/edit')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_delete_a_reply_they_do_not_own()
    {
        Reply::factory()->create();

        $this->login();

        $this->delete('/replies/1')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_mark_a_reply_as_the_solution_of_the_thread_if_they_do_not_own_the_thread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create(['author_id' => $user->id(), 'slug' => 'the-first-thread']);
        $reply = Reply::factory()->create(['replyable_id' => $thread->id()]);

        $this->login();

        $this->put('/forum/the-first-thread/mark-solution/'.$reply->id())
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_reply_to_a_thread_if_the_last_reply_is_older_than_six_months()
    {
        $thread = Thread::factory()->old()->create();

        $this->login();

        $this->visit("/forum/{$thread->slug}")
            ->dontSee('value="Reply"')
            ->seeText(
                'The last reply to this thread was more than six months ago. Please consider opening a new thread if you have a similar question.',
            );
    }

    /** @test */
    public function verified_users_can_see_the_reply_input()
    {
        $thread = Thread::factory()->create();

        $this->login();

        $this->visit("/forum/{$thread->slug}")
            ->see('name="body"');
    }

    /** @test */
    public function unverified_users_cannot_see_the_reply_input()
    {
        $thread = Thread::factory()->create();

        $this->login(['email_verified_at' => null]);

        $this->visit("/forum/{$thread->slug}")
            ->dontSee('name="body"')
            ->seeText(
                'You\'ll need to verify your account before participating in this thread.',
            );
    }
}
