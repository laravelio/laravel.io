<?php

namespace Tests\Functional;

use App\Forum\Thread;
use App\Forum\Topics\Topic;
use App\Replies\Reply;
use App\Tags\Tag;
use App\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_see_a_list_of_topics_and_latest_threads()
    {
        $topic = $this->create(Topic::class, ['name' => 'Eloquent']);
        $this->create(Thread::class, ['subject' => 'The first thread', 'topic_id' => $topic->id()]);
        $this->create(Thread::class, ['subject' => 'The second thread', 'topic_id' => $topic->id()]);

        $this->visit('/forum')
            ->see('Eloquent')
            ->see('The first thread')
            ->see('The second thread');
    }

    /** @test */
    function we_can_see_a_single_thread()
    {
        $this->create(Thread::class, [
            'subject' => 'The first thread',
            'slug' => 'the-first-thread',
        ]);

        $this->visit('/forum/the-first-thread')
            ->see('The first thread');
    }

    /** @test */
    function we_cannot_create_a_thread_when_not_logged_in()
    {
        $this->visit('/forum/create-thread')
            ->seePageIs('/login');
    }

    /** @test */
    function the_thread_subject_cannot_be_an_url()
    {
        $topic = $this->create(Topic::class, ['name' => 'Eloquent']);
        $tag = $this->create(Tag::class, ['name' => 'Test Tag']);

        $this->login();

        $this->visit('/forum/create-thread')
            ->submitForm('Create Thread', [
                'topic' => $topic->id(),
                'subject' => 'http://example.com',
                'body' => 'This text explains how to work with Eloquent.',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/create-thread')
            ->see('The subject field cannot contain an url.');
    }

    /** @test */
    function we_can_create_a_thread()
    {
        $topic = $this->create(Topic::class, ['name' => 'Eloquent']);
        $tag = $this->create(Tag::class, ['name' => 'Test Tag']);

        $this->login();

        $this->visit('/forum/create-thread')
            ->submitForm('Create Thread', [
                'topic' => $topic->id(),
                'subject' => 'How to work with Eloquent?',
                'body' => 'This text explains how to work with Eloquent.',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/how-to-work-with-eloquent')
            ->see('Eloquent')
            ->see('Test Tag')
            ->see('Thread successfully created!');
    }

    /** @test */
    function we_can_edit_a_thread()
    {
        $user = $this->login();

        $currentTopic = $this->create(Topic::class, ['name' => 'Laravel']);
        $newTopic = $this->create(Topic::class, ['name' => 'Spark']);
        $tag = $this->create(Tag::class, ['name' => 'Test Tag']);
        $this->create(Thread::class, [
            'author_id' => $user->id(),
            'topic_id' => $currentTopic->id(),
            'slug' => 'my-first-thread',
        ]);

        $this->visit('/forum/my-first-thread/edit')
            ->submitForm('Update', [
                'topic' => $newTopic->id(),
                'subject' => 'How to work with Eloquent?',
                'body' => 'This text explains how to work with Eloquent.',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/how-to-work-with-eloquent')
            ->see('How to work with Eloquent?')
            ->see('Spark')
            ->see('Test Tag')
            ->see('Thread successfully updated!');
    }

    /** @test */
    function we_cannot_edit_a_thread_we_do_not_own()
    {
        $this->create(Thread::class, ['slug' => 'my-first-thread']);

        $this->login();

        $this->get('/forum/my-first-thread/edit')
            ->assertResponseStatus(403);

        // I wish I could do this.
        //$this->visit('/forum/my-first-thread/edit')
        //    ->see('Forbidden');
    }

    /** @test */
    function we_cannot_delete_a_thread_we_do_not_own()
    {
        $this->create(Thread::class, ['slug' => 'my-first-thread']);

        $this->login();

        $this->get('/forum/my-first-thread/delete')
            ->assertResponseStatus(403);

        // I wish I could do this.
        //$this->visit('/forum/my-first-thread/delete')
        //    ->see('Forbidden');
    }

    /** @test */
    function we_can_add_a_reply_to_a_thread()
    {
        $this->login();

        $this->create(Thread::class, ['subject' => 'The first thread', 'slug' => 'the-first-thread']);

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

        $thread = $this->create(Thread::class, ['slug' => 'the-first-thread']);
        $this->create(Reply::class, [
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

        $this->create(Reply::class, ['body' => 'The first reply']);

        $this->get('/replies/1/edit')
            ->assertResponseStatus(403);
    }

    /** @test */
    function we_cannot_delete_a_reply_we_do_not_own()
    {
        $this->login();

        $this->create(Reply::class, ['body' => 'The first reply']);

        $this->get('/replies/1/delete')
            ->assertResponseStatus(403);
    }

    /** @test */
    function we_cannot_mark_a_reply_as_the_solution_of_the_thread_if_we_do_not_own_the_thread()
    {
        $this->login();

        $user = $this->create(User::class);
        $thread = $this->create(Thread::class, [
            'author_id' => $user->id(),
            'subject' => 'The first thread',
            'slug' => 'the-first-thread',
        ]);
        $reply = $this->create(Reply::class, ['body' => 'The first reply', 'replyable_id' => $thread->id()]);

        $this->get('/forum/the-first-thread/mark-solution/'.$reply->id())
            ->assertResponseStatus(403);
    }
}
