<?php

namespace Tests\Integration\Jobs;

use App\Exceptions\CannotLikeItem;
use App\Jobs\LikeReply;
use App\Models\Reply;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_like_a_reply()
    {
        $user = User::factory()->create();
        $reply = Reply::factory()->create();

        $this->dispatch(new LikeReply($reply, $user));

        $this->assertTrue($reply->fresh()->isLikedBy($user));
    }

    /** @test */
    public function we_cannot_like_a_reply_twice()
    {
        $user = User::factory()->create();
        $reply = Reply::factory()->create();

        $this->dispatch(new LikeReply($reply, $user));

        $this->assertTrue($reply->fresh()->isLikedBy($user));

        $this->expectException(CannotLikeItem::class);

        $this->dispatch(new LikeReply($reply, $user));
    }
}
