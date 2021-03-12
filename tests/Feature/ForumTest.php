<?php

namespace Tests\Feature;

use App\Http\Livewire\LikeReply;
use App\Http\Livewire\LikeThread;
use App\Models\Reply;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;

class ForumTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_see_a_list_of_latest_threads()
    {
        Thread::factory()->create(['subject' => 'The first thread']);
        Thread::factory()->create(['subject' => 'The second thread']);

        $this->visit('/forum')
            ->see('The first thread')
            ->see('The second thread');
    }

    /** @test */
    public function users_can_see_when_a_thread_is_resolved()
    {
        Thread::factory()->create(['subject' => 'The first thread']);
        $thread = Thread::factory()->create(['subject' => 'The second thread']);
        $reply = Reply::factory()->create();
        $thread->solutionReplyRelation()->associate($reply)->save();

        $this->visit('/forum')
            ->see('The first thread')
            ->see('The second thread')
            ->see('Resolved')
            ->see(route('thread', $thread->slug()).'#'.$thread->solution_reply_id);
    }

    /** @test */
    public function users_can_see_a_single_thread()
    {
        Thread::factory()->create([
            'subject' => 'The first thread',
            'slug' => 'the-first-thread',
        ]);

        $this->visit('/forum/the-first-thread')
            ->see('The first thread');
    }

    /** @test */
    public function users_cannot_create_a_thread_when_not_logged_in()
    {
        $this->visit('/forum/create-thread')
            ->seePageIs('/login');
    }

    /** @test */
    public function the_thread_subject_cannot_be_an_url()
    {
        $tag = Tag::factory()->create(['name' => 'Test Tag']);

        $this->login();

        $this->post('/forum/create-thread', [
            'subject' => 'http://example.com Foo title',
            'body' => 'This text explains how to work with Eloquent.',
            'tags' => [$tag->id()],
        ])
            ->assertSessionHasErrors(['subject' => 'The subject field cannot contain an url.']);
    }

    /** @test */
    public function users_can_create_a_thread()
    {
        $tag = Tag::factory()->create(['name' => 'Test Tag']);

        $this->login();

        $this->post('/forum/create-thread', [
            'subject' => 'How to work with Eloquent?',
            'body' => 'This text explains how to work with Eloquent.',
            'tags' => [$tag->id()],
        ])
            ->assertRedirectedTo('/forum/how-to-work-with-eloquent')
            ->assertSessionHas('success', 'Thread successfully created!');
    }

    /** @test */
    public function users_can_edit_a_thread()
    {
        $user = $this->createUser();
        $tag = Tag::factory()->create(['name' => 'Test Tag']);
        Thread::factory()->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-thread',
        ]);

        $this->loginAs($user);

        $this->put('/forum/my-first-thread', [
            'subject' => 'How to work with Eloquent?',
            'body' => 'This text explains how to work with Eloquent.',
            'tags' => [$tag->id()],
        ])
            ->assertRedirectedTo('/forum/how-to-work-with-eloquent')
            ->assertSessionHas('success', 'Thread successfully updated!');
    }

    /** @test */
    public function users_cannot_edit_a_thread_they_do_not_own()
    {
        Thread::factory()->create(['slug' => 'my-first-thread']);

        $this->login();

        $this->get('/forum/my-first-thread/edit')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_delete_a_thread_they_do_not_own()
    {
        Thread::factory()->create(['slug' => 'my-first-thread']);

        $this->login();

        $this->delete('/forum/my-first-thread')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_create_a_thread_with_a_subject_that_is_too_long()
    {
        $tag = Tag::factory()->create(['name' => 'Test Tag']);

        $this->login();

        $response = $this->post('/forum/create-thread', [
            'subject' => 'How to make Eloquent, Doctrine, Entities and Annotations work together in Laravel?',
            'body' => 'This is a thread with 82 characters in the subject',
            'tags' => [$tag->id()],
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['subject' => 'The subject may not be greater than 60 characters.']);
    }

    /** @test */
    public function users_cannot_edit_a_thread_with_a_subject_that_is_too_long()
    {
        $user = $this->createUser();
        $tag = Tag::factory()->create(['name' => 'Test Tag']);
        Thread::factory()->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-thread',
        ]);

        $this->loginAs($user);

        $response = $this->put('/forum/my-first-thread', [
            'subject' => 'How to make Eloquent, Doctrine, Entities and Annotations work together in Laravel?',
            'body' => 'This is a thread with 82 characters in the subject',
            'tags' => [$tag->id()],
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['subject' => 'The subject may not be greater than 60 characters.']);
    }

    /** @test */
    public function a_user_can_toggle_a_like_on_a_thread()
    {
        $this->login();

        $thread = Thread::factory()->create();

        Livewire::test(LikeThread::class, ['thread' => $thread])
            ->assertSee("0\n")
            ->call('toggleLike')
            ->assertSee("1\n")
            ->call('toggleLike')
            ->assertSee("0\n");
    }

    /** @test */
    public function a_logged_out_user_cannot_toggle_a_like_on_a_thread()
    {
        $thread = Thread::factory()->create();

        Livewire::test(LikeThread::class, ['thread' => $thread])
            ->assertSee("0\n")
            ->call('toggleLike')
            ->assertSee("0\n");
    }

    /** @test */
    public function a_user_can_toggle_a_like_on_a_reply()
    {
        $this->login();

        $reply = Reply::factory()->create();

        Livewire::test(LikeReply::class, ['reply' => $reply])
            ->assertSee("0\n")
            ->call('toggleLike')
            ->assertSee("1\n")
            ->call('toggleLike')
            ->assertSee("0\n");
    }

    /** @test */
    public function a_logged_out_user_cannot_toggle_a_like_on_a_reply()
    {
        $reply = Reply::factory()->create();

        Livewire::test(LikeReply::class, ['reply' => $reply])
            ->assertSee("0\n")
            ->call('toggleLike')
            ->assertSee("0\n");
    }

    /** @test */
    public function user_can_see_standalone_links_in_reply()
    {
        $thread = Thread::factory()->create(['slug' => 'the-first-thread']);
        Reply::factory()->create([
            'body' => 'https://github.com/laravelio/laravel.io check this cool project',
            'replyable_id' => $thread->id(),
        ]);

        $this->visit("/forum/{$thread->slug}")
            ->see('&lt;a href=\\"https:\\/\\/github.com\\/laravelio\\/laravel.io\\" rel=\\"nofollow\\" target=\\"_blank\\"&gt;https:\\/\\/github.com\\/laravelio\\/laravel.io&lt;\\/a&gt;');
    }

    /** @test */
    public function user_can_see_standalone_links_in_thread()
    {
        $thread = Thread::factory()->create([
            'slug' => 'the-first-thread',
            'body' => 'https://github.com/laravelio/laravel.io check this cool project',
        ]);
        Reply::factory()->create(['replyable_id' => $thread->id()]);

        $this->visit("/forum/{$thread->slug()}")
            ->see('&lt;a href=\\"https:\\/\\/github.com\\/laravelio\\/laravel.io\\" rel=\\"nofollow\\" target=\\"_blank\\"&gt;https:\\/\\/github.com\\/laravelio\\/laravel.io&lt;\\/a&gt;');
    }

    /** @test */
    public function an_invalid_filter_defaults_to_the_most_recent_threads()
    {
        Thread::factory()->create(['subject' => 'The first thread']);
        Thread::factory()->create(['subject' => 'The second thread']);

        $this->visit('/forum?filter=something-invalid')
            ->see('href="http://localhost/forum?filter=recent" aria-current="page"');
    }

    /** @test */
    public function an_invalid_filter_on_tag_view_defaults_to_the_most_recent_threads()
    {
        $tag = Tag::factory()->create();

        $this->visit("/forum/tags/{$tag->slug}?filter=something-invalid")
            ->see('href="http://localhost/forum/tags/'.$tag->slug.'?filter=recent" aria-current="page"');
    }
}
