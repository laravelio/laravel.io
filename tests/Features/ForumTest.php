<?php

namespace Tests\Features;

use App\Models\Thread;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

class ForumTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_see_a_list_of_latest_threads()
    {
        factory(Thread::class)->create(['subject' => 'The first thread']);
        factory(Thread::class)->create(['subject' => 'The second thread']);

        $this->visit('/forum')
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
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

        $this->login();

        $this->visit('/forum/create-thread')
            ->submitForm('Create Thread', [
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
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

        $this->login();

        $this->visit('/forum/create-thread')
            ->submitForm('Create Thread', [
                'subject' => 'How to work with Eloquent?',
                'body' => 'This text explains how to work with Eloquent.',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/how-to-work-with-eloquent')
            ->see('How to work with Eloquent?')
            ->see('Test Tag')
            ->see('Thread successfully created!');
    }

    /** @test */
    function we_can_edit_a_thread()
    {
        $user = $this->login();

        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        factory(Thread::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-thread',
        ]);

        $this->visit('/forum/my-first-thread/edit')
            ->submitForm('Update Thread', [
                'subject' => 'How to work with Eloquent?',
                'body' => 'This text explains how to work with Eloquent.',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/how-to-work-with-eloquent')
            ->see('How to work with Eloquent?')
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
