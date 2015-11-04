<?php
namespace Lio\Tests\Integration\Replies;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Forum\EloquentThread;
use Lio\Replies\Reply;
use Lio\Testing\RepositoryTest;
use Lio\Tests\TestCase;

class ReplyRepositoryTest extends TestCase
{
    use DatabaseMigrations, RepositoryTest;

    protected $repoName = 'Lio\\Replies\\ReplyRepository';

    /** @test */
    function create_for_thread()
    {
        $thread = factory(EloquentThread::class)->create();
        $user = $this->createUser();

        $this->assertInstanceOf(Reply::class, $this->repo->create($thread, $user, 'Foo'));
    }
}
