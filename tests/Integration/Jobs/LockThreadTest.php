<?php

use App\Exceptions\CannotLockItem;
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

    $this->dispatch(new LockThread($user, $thread));

    expect($thread->isLockedBy($user))->toBeTrue();
});

test('we cannot lock a locked thread', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create();

    $this->dispatch(new LockThread($user, $thread));

    expect($thread->isLockedBy($user))->toBeTrue();

    $this->expectException(CannotLockItem::class);

    $this->dispatch(new LockThread($user, $thread));
});
