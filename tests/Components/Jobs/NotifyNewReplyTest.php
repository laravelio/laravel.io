<?php

namespace Tests\Components\Jobs;

use App\User;
use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use App\Jobs\NotifyNewReply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotifyNewReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_not_notify_the_reply_author()
    {
        $thread = factory(Thread::class)->create();
        $reply = $this->createReply($thread);

        $user = $reply->author();

        (new NotifyNewReply($reply))->handle();

        $this->assertCount(0, $user->notifications()->get());
    }

    /** @test */
    public function we_can_notify_the_user_when_new_reply_is_created()
    {
        $user = $this->createUser();
        $thread = factory(Thread::class)->create();
        $thread->subscribers()->attach($user->id);

        $reply = $this->createReply($thread);

        (new NotifyNewReply($reply))->handle();

        $this->assertCount(1, $user->notifications()->get());
    }

    protected function createReply(Thread $thread)
    {
        $reply = factory(Reply::class)->create();
        $reply->to($thread);
        $reply->save();

        return $reply;
    }
}
