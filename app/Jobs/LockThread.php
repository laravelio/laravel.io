<?php

namespace App\Jobs;

use App\Models\Thread;
use App\Models\User;

final class LockThread
{
    public function __construct(private User $user, private Thread $thread)
    {
    }

    public function handle(): void
    {
        if ($this->thread->isUnlocked()) {
            $this->thread->lockedByRelation()->associate($this->user);
            $this->thread->locked_at = now();
            $this->thread->save();
        }
    }
}
