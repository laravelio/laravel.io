<?php

namespace App\Jobs;

use App\Models\Thread;

final class UnlockThread
{
    /**
     * @var \App\Models\Thread
     */
    private $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function handle()
    {
        $this->thread->unlock();
    }
}
