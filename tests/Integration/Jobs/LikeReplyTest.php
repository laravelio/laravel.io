<?php

use App\Exceptions\CannotLikeItem;
use App\Jobs\LikeReply;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can like a reply', function () {
    $user = User::factory()->create();
    $reply = Reply::factory()->create();

    $this->dispatch(new LikeReply($reply, $user));

    expect($reply->fresh()->isLikedBy($user))->toBeTrue();
});

test('we cannot like a reply twice', function () {
    $user = User::factory()->create();
    $reply = Reply::factory()->create();

    $this->dispatch(new LikeReply($reply, $user));

    expect($reply->fresh()->isLikedBy($user))->toBeTrue();

    $this->expectException(CannotLikeItem::class);

    $this->dispatch(new LikeReply($reply, $user));
});
