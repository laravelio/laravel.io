<?php

use App\Jobs\UnlikeThread;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can unlike a thread', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create();

    $thread->likedBy($user);
    expect($thread->fresh()->isLikedBy($user))->toBeTrue();

    $this->dispatch(new UnlikeThread($thread, $user));

    expect($thread->fresh()->isLikedBy($user))->toBeFalse();
});
