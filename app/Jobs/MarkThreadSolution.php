<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;

final class MarkThreadSolution
{
    public function __construct(
        private Thread $thread,
        private Reply $solution,
        private User $user
    ) {
    }

    public function handle()
    {
        $this->thread->markSolution($this->solution, $this->user);
    }
}
