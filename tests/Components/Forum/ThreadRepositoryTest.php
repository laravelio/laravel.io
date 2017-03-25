<?php

namespace Tests\Components\Forum;

use App\Forum\ThreadData;
use App\Forum\Thread;
use App\Forum\ThreadRepository;
use App\Forum\Topic;
use App\Replies\Reply;
use App\Users\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\TestsRepository;

class ThreadRepositoryTest extends TestCase
{
    use DatabaseMigrations, TestsRepository;

    /**
     * @var \App\Forum\ThreadRepository
     */
    protected $repo = ThreadRepository::class;

    /** @test */
    public function find_all_paginated()
    {
        $this->create(Thread::class, [], 2);

        $threads = $this->repo->findAllPaginated();

        $this->assertInstanceOf(Paginator::class, $threads);
        $this->assertCount(2, $threads);
    }

    /** @test */
    public function find_by_id()
    {
        $thread = $this->create(Thread::class, ['slug' => 'foo']);

        $this->assertInstanceOf(Thread::class, $this->repo->find($thread->id()));
    }

    /** @test */
    public function find_by_slug()
    {
        $this->create(Thread::class, ['slug' => 'foo']);

        $this->assertInstanceOf(Thread::class, $this->repo->findBySlug('foo'));
    }

    /** @test */
    function we_can_create_a_thread()
    {
        $this->assertInstanceOf(Thread::class, $this->repo->create($this->threadData()));
    }

    /** @test */
    function we_can_update_a_thread()
    {
        $thread = $this->create(Thread::class, ['body' => 'foo']);
        $this->create(Thread::class, ['body' => 'bar']);

        $this->repo->update($thread, ['body' => 'baz']);

        $this->assertEquals('baz', $this->repo->find(1)->body());

        // Make sure other records remain unaltered.
        $this->assertEquals('bar', $this->repo->find(2)->body());
    }

    /** @test */
    function we_can_mark_and_unmark_a_reply_as_the_solution()
    {
        $thread = $this->create(Thread::class);
        $reply = $this->create(Reply::class, ['replyable_id' => $thread->id()]);

        $this->assertFalse($thread->isSolutionReply($reply));

        $thread = $this->repo->markSolution($reply);

        $this->assertTrue($thread->isSolutionReply($reply));

        $thread = $this->repo->unmarkSolution($thread);

        $this->assertFalse($thread->isSolutionReply($reply));
    }

    private function threadData(): ThreadData
    {
        return new class extends ThreadRepositoryTest implements ThreadData
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
                return $this->create(Topic::class);
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
