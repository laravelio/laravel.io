<?php

namespace Tests\Components\Replies;

use App\Forum\Thread;
use App\Replies\ReplyData;
use App\Replies\Reply;
use App\Replies\ReplyAble;
use App\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_create_a_reply()
    {
        $this->assertInstanceOf(Reply::class, Reply::createFromData($this->replyData()));
    }

    private function replyData()
    {
        return new class extends ReplyTest implements ReplyData
        {
            public function replyAble(): ReplyAble
            {
                return factory(Thread::class)->create();
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
