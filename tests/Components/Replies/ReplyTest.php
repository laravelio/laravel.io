<?php

namespace Tests\Components\Replies;

use App\Http\Requests\ReplyRequest;
use App\Models\Thread;
use App\Models\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_create_a_reply()
    {
        $this->assertInstanceOf(Reply::class, Reply::createFromRequest($this->replyData()));
    }

    private function replyData()
    {
        return new class extends ReplyRequest
        {
            public function replyAble()
            {
                return factory(Thread::class)->create();
            }

            public function author(): User
            {
                return factory(User::class)->create();
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
