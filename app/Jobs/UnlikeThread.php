<?php

namespace App\Jobs;

use App\Models\Thread;
use App\Models\User;

final class UnlikeThread
{
    public function __construct(
        private Thread $thread,
        private User $user
    ) {
    }

    public function handle(): void
    {
        $this->thread->dislikedBy($this->user);
    }
}
