<?php
namespace Lio\Tests\Functional;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Forum\EloquentThread;
use Lio\Tests\TestCase;

class ForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_see_a_list_of_threads()
    {
        factory(EloquentThread::class)->create([
            'subject' => 'The first thread',
        ]);
        factory(EloquentThread::class)->create([
            'subject' => 'The second thread',
        ]);

        $this->visit('/forum')
            ->see('The first thread')
            ->see('The second thread');
    }

    /** @test */
    function we_can_see_a_single_thread()
    {
        factory(EloquentThread::class)->create([
            'subject' => 'The first thread',
            'slug' => 'the-first-thread',
        ]);

        $this->visit('/forum/the-first-thread')
            ->see('The first thread');
    }

    /** @test */
    function we_can_add_a_reply_to_a_thread()
    {
        $this->be($this->createUser());

        factory(EloquentThread::class)->create([
            'subject' => 'The first thread',
            'slug' => 'the-first-thread',
        ]);

        $this->visit('/forum/the-first-thread')
            ->type('The first reply', 'body')
            ->press('Reply')
            ->see('The first thread')
            ->see('The first reply');
    }
}
