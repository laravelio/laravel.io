<?php

use App\Jobs\LockThread;
use App\Jobs\UnlockThread;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can unlock a thread', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create();

    $this->dispatch(new LockThread($user, $thread));

    expect($thread->isLockedBy($user))->toBeTrue();
    expect($thread->locked_at)->not()->toBeNull();

    $this->dispatch(new UnlockThread($thread));

    expect($thread->isUnlocked())->toBeTrue();
    expect($thread->locked_at)->toBeNull();
});
