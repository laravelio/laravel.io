<?php

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can like and unlike reply', function () {
    $user = $this->createUser();

    $reply = Reply::factory()->create();

    $this->assertFalse($reply->isLikedBy($user));

    $reply->likedBy($user);

    $this->assertTrue($reply->isLikedBy($user));

    $reply->dislikedBy($user);

    $this->assertFalse($reply->isLikedBy($user));
});
