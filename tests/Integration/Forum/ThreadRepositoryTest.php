<?php
namespace Lio\Tests\Integration\Forum;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Forum\EloquentThread;
use Lio\Forum\Thread;
use Lio\Testing\RepositoryTest;
use Lio\Tests\TestCase;

class ThreadRepositoryTest extends TestCase
{
    use DatabaseMigrations, RepositoryTest;

    protected $repoName = 'Lio\\Forum\\ThreadRepository';

    /** @test */
    public function find_all()
    {
        factory(EloquentThread::class, 2)->create();

        $this->assertCount(2, $this->repo->findAll());
    }

    /** @test */
    public function find_by_slug()
    {
        factory(EloquentThread::class)->create(['slug' => 'foo']);

        $this->assertInstanceOf(Thread::class, $this->repo->findBySlug('foo'));
    }
}
