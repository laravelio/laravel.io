<?php
namespace Lio\Tests\Integration\Replies;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Forum\EloquentThread;
use Lio\Replies\EloquentReply;
use Lio\Replies\Reply;
use Lio\Replies\ReplyRepository;
use Lio\Testing\RepositoryTest;
use Lio\Tests\TestCase;

class ReplyRepositoryTest extends TestCase
{
    use DatabaseMigrations, RepositoryTest;

    protected $repoName = ReplyRepository::class;

    /** @test */
    function we_can_create_a_reply()
    {
        $thread = factory(EloquentThread::class)->create();
        $user = $this->createUser();

        $this->assertInstanceOf(Reply::class, $this->repo->create($thread, $user, 'Foo'));
    }

    /** @test */
    function we_can_update_a_reply()
    {
        $reply = factory(EloquentReply::class)->create(['body' => 'foo']);
        factory(EloquentReply::class)->create(['body' => 'bar']);

        $this->repo->update($reply, ['body' => 'baz']);

        $this->assertEquals('baz', $this->repo->find(1)->body());

        // Make sure other records remain unaltered.
        $this->assertEquals('bar', $this->repo->find(2)->body());
    }

    /** @test */
    function we_can_delete_a_reply()
    {
        $reply = factory(EloquentReply::class)->create();

        $this->seeInDatabase('replies', ['id' => 1]);

        $this->repo->delete($reply);

        $this->notSeeInDatabase('replies', ['id' => 1]);
    }
}
