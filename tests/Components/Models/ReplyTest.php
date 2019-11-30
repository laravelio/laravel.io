<?php

namespace Tests\Components\Models;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_like_and_unlike_reply()
    {
        $user = $this->createUser();

        $reply = factory(Reply::class)->create();

        $this->assertFalse($reply->isLikedBy($user));

        $reply->likedBy($user);

        $this->assertTrue($reply->isLikedBy($user));

        $reply->dislikedBy($user);

        $this->assertFalse($reply->isLikedBy($user));
    }
}
