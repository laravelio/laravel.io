<?php

namespace Tests\Components;

use App\Jobs\CreateThread;
use App\Jobs\DeleteThread;
use App\Models\Thread;
use App\Http\Requests\ThreadRequest;
use App\Models\Topic;
use App\Models\Reply;
use App\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
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
        $this->assertInstanceOf(Thread::class, (new CreateThread($this->threadRequest()))->handle());
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

    /** @test */
    function we_can_delete_a_thread_and_its_replies()
    {
        $thread = factory(Thread::class)->create();
        factory(Reply::class)->create(['replyable_id' => $thread->id()]);

        (new DeleteThread($thread))->handle();

        $this->assertDatabaseMissing('threads', ['id' => $thread->id()]);
        $this->assertDatabaseMissing('replies', ['replyable_id' => $thread->id()]);
    }

    private function threadRequest(): ThreadRequest
    {
        return new class extends ThreadRequest
        {
            public function author(): User
            {
                return factory(User::class)->create();
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
                return factory(Topic::class)->create();
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
