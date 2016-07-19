<?php

namespace Lio\Tests\Integration\Forum;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Forum\Thread;
use Lio\Forum\ThreadRepository;
use Lio\Forum\Topics\Topic;
use Lio\Testing\RepositoryTest;
use Lio\Tests\TestCase;

class ThreadRepositoryTest extends TestCase
{
    use DatabaseMigrations, RepositoryTest;

    protected $repoName = ThreadRepository::class;

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
        $user = $this->createUser();
        $topic = $this->create(Topic::class);

        $this->assertInstanceOf(Thread::class, $this->repo->create($user, $topic, 'Foo', 'Baz'));
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
    function we_can_delete_a_thread()
    {
        $thread = $this->create(Thread::class);

        $this->seeInDatabase('threads', ['id' => 1]);

        $this->repo->delete($thread);

        $this->notSeeInDatabase('threads', ['id' => 1]);
    }
}
