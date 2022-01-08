<?php

use App\Jobs\LockThread;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can lock a thread', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create();

    expect($thread->locked_at)->toBeNull();

    $this->dispatch(new LockThread($user, $thread));

    expect($thread->isLockedBy($user))->toBeTrue();
    expect($thread->locked_at)->not()->toBeNull();
});

test('locking an already locked thread has no side effects', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create();

    $this->dispatch(new LockThread($user, $thread));

    expect($thread->isLockedBy($user))->toBeTrue();

    $lockedAt = $thread->locked_at;

    $this->dispatch(new LockThread($user, $thread));

    expect($thread->locked_at)->toEqual($lockedAt);
});
