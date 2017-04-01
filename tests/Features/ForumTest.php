<?php

namespace Tests\Features;

use App\Forum\Thread;
use App\Models\Topic;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

class ForumTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_see_a_list_of_topics_and_latest_threads()
    {
        $topic = factory(Topic::class)->create(['name' => 'Eloquent']);
        factory(Thread::class)->create(['subject' => 'The first thread', 'topic_id' => $topic->id()]);
        factory(Thread::class)->create(['subject' => 'The second thread', 'topic_id' => $topic->id()]);

        $this->visit('/forum')
            ->see('Eloquent')
            ->see('The first thread')
            ->see('The second thread');
    }

    /** @test */
    function we_can_see_a_single_thread()
    {
        factory(Thread::class)->create([
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
        $topic = factory(Topic::class)->create(['name' => 'Eloquent']);
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

        $this->login();

        $this->visit('/forum/create-thread')
            ->submitForm('Create Thread', [
                'topic' => $topic->id(),
                'subject' => 'http://example.com Foo title',
                'body' => 'This text explains how to work with Eloquent.',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/create-thread')
            ->see('The subject field cannot contain an url.');
    }

    /** @test */
    function we_can_create_a_thread()
    {
        $topic = factory(Topic::class)->create(['name' => 'Eloquent']);
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

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

        $currentTopic = factory(Topic::class)->create(['name' => 'Laravel']);
        $newTopic = factory(Topic::class)->create(['name' => 'Spark']);
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        factory(Thread::class)->create([
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
        factory(Thread::class)->create(['slug' => 'my-first-thread']);

        $this->login();

        $this->get('/forum/my-first-thread/edit')
            ->assertForbidden();
    }

    /** @test */
    function we_cannot_delete_a_thread_we_do_not_own()
    {
        factory(Thread::class)->create(['slug' => 'my-first-thread']);

        $this->login();

        $this->delete('/forum/my-first-thread')
            ->assertForbidden();
    }
}
