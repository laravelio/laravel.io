<?php

use App\Jobs\UnlikeReply;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can unlike a reply', function () {
    $user = User::factory()->create();
    $reply = Reply::factory()->create();

    $reply->likedBy($user);
    $this->assertTrue($reply->fresh()->isLikedBy($user));

    $this->dispatch(new UnlikeReply($reply, $user));

    $this->assertFalse($reply->fresh()->isLikedBy($user));
});
