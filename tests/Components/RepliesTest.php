<?php

namespace Tests\Components;

use App\Http\Requests\ReplyRequest;
use App\Jobs\CreateReply;
use App\Models\Thread;
use App\Models\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RepliesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_create_a_reply()
    {
        $this->assertInstanceOf(Reply::class, (new CreateReply($this->replyRequest()))->handle());
    }

    private function replyRequest(): ReplyRequest
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
