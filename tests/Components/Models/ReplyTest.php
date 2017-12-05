<?php

namespace Tests\Components\Models;

use Tests\TestCase;
use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

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
