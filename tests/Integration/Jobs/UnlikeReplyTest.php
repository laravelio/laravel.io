<?php

namespace Tests\Integration\Jobs;

use App\Jobs\UnlikeReply;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnlikeReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_unlike_a_reply()
    {
        $user = User::factory()->create();
        $reply = Reply::factory()->create();

        $reply->likedBy($user);
        $this->assertTrue($reply->fresh()->isLikedBy($user));

        $this->dispatch(new UnlikeReply($reply, $user));

        $this->assertFalse($reply->fresh()->isLikedBy($user));
    }
}
