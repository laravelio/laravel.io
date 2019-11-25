<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\Reply;
use App\Models\Tag;
use App\Models\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

class ForumTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_see_a_list_of_latest_threads()
    {
        factory(Thread::class)->create(['subject' => 'The first thread']);
        factory(Thread::class)->create(['subject' => 'The second thread']);

        $this->visit('/forum')
            ->see('The first thread')
            ->see('The second thread');
    }

    /** @test */
    public function users_can_see_when_a_thread_is_resolved()
    {
        factory(Thread::class)->create(['subject' => 'The first thread']);
        $thread = factory(Thread::class)->create(['subject' => 'The second thread']);
        $reply = factory(Reply::class)->create();
        $thread->solutionReplyRelation()->associate($reply)->save();

        $this->visit('/forum')
            ->see('The first thread')
            ->see('The second thread')
            ->see('View solution')
            ->click('View solution')
            ->seeRouteIs('thread', ['thread' => $thread->slug()]);
    }

    /** @test */
    public function users_can_see_a_single_thread()
    {
        factory(Thread::class)->create([
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
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

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
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

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
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        factory(Thread::class)->create([
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
        factory(Thread::class)->create(['slug' => 'my-first-thread']);

        $this->login();

        $this->get('/forum/my-first-thread/edit')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_delete_a_thread_they_do_not_own()
    {
        factory(Thread::class)->create(['slug' => 'my-first-thread']);

        $this->login();

        $this->delete('/forum/my-first-thread')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_create_a_thread_with_a_subject_that_is_too_long()
    {
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

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
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        factory(Thread::class)->create([
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
    public function users_can_like_a_thread()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create(['author_id' => $user->id(), 'slug' => 'the-first-thread']);

        $this->loginAs($user);
        $this->put("/forum/{$thread->slug}/like")
            ->assertRedirectedTo('/forum/the-first-thread');

        $this->seeInDatabase('likes', [
            'user_id' => $user->id,
            'likeable_id' => $thread->id,
            'likeable_type' => 'threads',
        ]);
    }

    /** @test */
    public function users_can_unlike_a_thread()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create(['author_id' => $user->id(), 'slug' => 'the-first-thread']);
        factory(Like::class)->states('thread')->create(['user_id' => $user->id, 'likeable_id' => $thread->id]);

        $this->loginAs($user);
        $this->delete("/forum/{$thread->slug}/unlike")
            ->assertRedirectedTo('/forum/the-first-thread');

        $this->notSeeInDatabase('likes', [
            'user_id' => $user->id,
            'likeable_id' => $thread->id,
            'likeable_type' => 'threads',
        ]);
    }
}
