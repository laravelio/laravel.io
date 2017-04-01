<?php

namespace App\Jobs;

use App\Models\Thread;

class UnmarkThreadSolution
{
    /**
     * @var \App\User
     */
    public $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function handle()
    {
        $this->thread->unmarkSolution();
    }
}
