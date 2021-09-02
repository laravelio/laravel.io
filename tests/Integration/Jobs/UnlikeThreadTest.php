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
    $this->assertTrue($thread->fresh()->isLikedBy($user));

    $this->dispatch(new UnlikeThread($thread, $user));

    $this->assertFalse($thread->fresh()->isLikedBy($user));
});
