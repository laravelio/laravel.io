<?php

namespace Tests\Components\Jobs;

use App\Jobs\DislikeReply;
use App\Models\Reply;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DislikeReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_dislike_a_reply()
    {
        $user = factory(User::class)->create();
        $reply = factory(Reply::class)->create();

        $reply->likedBy($user);
        $this->assertTrue($reply->fresh()->isLikedBy($user));

        $this->dispatch(new DislikeReply($reply, $user));

        $this->assertFalse($reply->fresh()->isLikedBy($user));
    }
}
