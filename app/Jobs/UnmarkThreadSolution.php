<?php

namespace App\Jobs;

use App\Models\Thread;

final class UnmarkThreadSolution
{
    public function __construct(
        private Thread $thread
    ) {
    }

    public function handle()
    {
        $this->thread->unmarkSolution();
    }
}
