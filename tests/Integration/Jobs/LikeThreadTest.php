<?php

use App\Exceptions\CannotLikeItem;
use App\Jobs\LikeThread;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can like a thread', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create();

    $this->dispatch(new LikeThread($thread, $user));

    expect($thread->fresh()->isLikedBy($user))->toBeTrue();
});

test('we cannot like a thread twice', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create();

    $this->dispatch(new LikeThread($thread, $user));

    expect($thread->fresh()->isLikedBy($user))->toBeTrue();

    $this->expectException(CannotLikeItem::class);

    $this->dispatch(new LikeThread($thread, $user));
});
