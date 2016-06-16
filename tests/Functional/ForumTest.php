<?php

namespace Lio\Tests\Functional;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Forum\Thread;
use Lio\Tests\TestCase;

class ForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_see_a_list_of_threads()
    {
        $this->create(Thread::class, ['subject' => 'The first thread']);
        $this->create(Thread::class, ['subject' => 'The second thread']);

        $this->visit('/forum')
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
    function we_cannot_create_a_thread_when_not_logged_in()
    {
        $this->visit('/forum/create-thread')
            ->seePageIs('/login');
    }

    /** @test */
    function we_can_create_a_thread_when_logged_in()
    {
        $this->login();

        $this->visit('/forum/create-thread')
            ->type('How to work with Eloquent?', 'subject')
            ->type('This text explains how to work with Eloquent.', 'body')
            ->press('Create Thread')
            ->seePageIs('/forum/how-to-work-with-eloquent');
    }

    /** @test */
    function we_can_edit_a_thread()
    {
        $this->create(Thread::class, ['slug' => 'my-first-thread']);

        $this->login();

        $this->visit('/forum/my-first-thread/edit')
            ->type('How to work with Eloquent?', 'subject')
            ->type('This text explains how to work with Eloquent.', 'body')
            ->press('Update')
            ->seePageIs('/forum/my-first-thread')
            ->see('How to work with Eloquent?');
    }
}
