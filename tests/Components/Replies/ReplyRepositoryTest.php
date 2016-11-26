<?php

namespace Tests\Components\Replies;

use App\Forum\Thread;
use App\Replies\ReplyData;
use App\Replies\Reply;
use App\Replies\ReplyAble;
use App\Replies\ReplyRepository;
use App\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\TestsRepository;

class ReplyRepositoryTest extends TestCase
{
    use DatabaseMigrations, TestsRepository;

    /**
     * @var \App\Replies\ReplyRepository
     */
    protected $repo = ReplyRepository::class;

    /** @test */
    function we_can_create_a_reply()
    {
        $this->assertInstanceOf(Reply::class, $this->repo->create($this->replyData()));
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

    private function replyData()
    {
        return new class extends ReplyRepositoryTest implements ReplyData
        {
            public function replyAble(): ReplyAble
            {
                return $this->create(Thread::class);
            }

            public function author(): User
            {
                return $this->createUser();
            }

            public function body(): string
            {
                return 'Foo';
            }

            public function ip()
            {
                return '';
            }
        };
    }
}
