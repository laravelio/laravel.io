<?php

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can like and unlike reply', function () {
    $user = $this->createUser();

    $reply = Reply::factory()->create();

    expect($reply->isLikedBy($user))->toBeFalse();

    $reply->likedBy($user);

    expect($reply->isLikedBy($user))->toBeTrue();

    $reply->dislikedBy($user);

    expect($reply->isLikedBy($user))->toBeFalse();
});
