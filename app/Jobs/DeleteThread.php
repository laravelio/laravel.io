<?php

namespace App\Jobs;

use App\Models\Thread;

final class DeleteThread
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
        $this->thread->delete();
    }
}
