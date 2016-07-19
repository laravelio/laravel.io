<?php

namespace Lio\Tests\Functional;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Forum\Thread;
use Lio\Forum\Topics\Topic;
use Lio\Replies\Reply;
use Lio\Tags\Tag;
use Lio\Tests\TestCase;

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
            ->see('Test Tag');
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
            ->seePageIs('/forum/my-first-thread')
            ->see('How to work with Eloquent?')
            ->see('Spark')
            ->see('Test Tag');
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

        $this->create(Thread::class, [
            'subject' => 'The first thread',
            'slug' => 'the-first-thread',
        ]);

        $this->visit('/forum/the-first-thread')
            ->type('The first reply', 'body')
            ->press('Reply')
            ->see('The first thread')
            ->see('The first reply');
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
            ->see('The edited reply');
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
}
