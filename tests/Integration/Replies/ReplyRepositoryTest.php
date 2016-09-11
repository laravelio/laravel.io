<?php

namespace Tests\Integration\Replies;

use App\Forum\Thread;
use App\Replies\Reply;
use App\Replies\ReplyRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\TestsRepositories;

class ReplyRepositoryTest extends TestCase
{
    use DatabaseMigrations, TestsRepositories;

    protected $repoName = ReplyRepository::class;

    /** @test */
    function we_can_create_a_reply()
    {
        $thread = $this->create(Thread::class);
        $user = $this->createUser();

        $this->assertInstanceOf(Reply::class, $this->repo->create($thread, $user, 'Foo'));
    }

    /** @test */
    function we_can_update_a_reply()
    {
        $reply = $this->create(Reply::class, ['body' => 'foo']);
        $this->create(Reply::class, ['body' => 'bar']);

        $this->repo->update($reply, ['body' => 'baz']);

        $this->assertEquals('baz', $this->repo->find(1)->body());

        // Make sure other records remain unaltered.
        $this->assertEquals('bar', $this->repo->find(2)->body());
    }

    /** @test */
    function we_can_delete_a_reply()
    {
        $reply = $this->create(Reply::class);

        $this->seeInDatabase('replies', ['id' => 1]);

        $this->repo->delete($reply);

        $this->notSeeInDatabase('replies', ['id' => 1]);
    }
}
