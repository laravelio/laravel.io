<?php

namespace App\Jobs;

use App\Models\Thread;

final class UnlockThread
{
    public function __construct(private Thread $thread)
    {
    }

    public function handle(): void
    {
        $this->thread->lockedByRelation()->dissociate();
        $this->thread->locked_at = null;
        $this->thread->save();
    }
}
