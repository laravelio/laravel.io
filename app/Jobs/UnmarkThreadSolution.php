<?php

namespace App\Jobs;

use App\Models\Thread;

final class UnmarkThreadSolution
{
    /**
     * @var \App\User
     */
    private $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function handle()
    {
        $this->thread->unmarkSolution();
    }
}
