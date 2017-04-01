<?php

namespace Tests\Components\Forum;

use App\Forum\ThreadData;
use App\Forum\Thread;
use App\Models\Topic;
use App\Replies\Reply;
use App\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function find_all_paginated()
    {
        factory(Thread::class, 2)->create();

        $threads = Thread::findAllPaginated();

        $this->assertInstanceOf(Paginator::class, $threads);
        $this->assertCount(2, $threads);
    }

    /** @test */
    public function find_by_slug()
    {
        factory(Thread::class)->create(['slug' => 'foo']);

        $this->assertInstanceOf(Thread::class, Thread::findBySlug('foo'));
    }

    /** @test */
    function we_can_create_a_thread()
    {
        $this->assertInstanceOf(Thread::class, Thread::createFromData($this->threadData()));
    }

    /** @test */
    function we_can_mark_and_unmark_a_reply_as_the_solution()
    {
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['replyable_id' => $thread->id()]);

        $this->assertFalse($thread->isSolutionReply($reply));

        $thread->markSolution($reply);

        $this->assertTrue($thread->isSolutionReply($reply));

        $thread->unmarkSolution();

        $this->assertFalse($thread->isSolutionReply($reply));
    }

    private function threadData(): ThreadData
    {
        return new class extends ThreadTest implements ThreadData
        {
            public function author(): User
            {
                return $this->createUser();
            }

            public function subject(): string
            {
                return 'Foo Thread';
            }

            public function body(): string
            {
                return 'Foo Thread Body';
            }

            public function topic(): Topic
            {
                return factory(\App\Models\Topic::class)->create();
            }

            public function ip()
            {
                return '';
            }

            public function tags(): array
            {
                return [];
            }
        };
    }
}
