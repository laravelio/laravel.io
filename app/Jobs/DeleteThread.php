<?php

namespace App\Jobs;

use App\Models\Thread;

final class DeleteThread
{
    public function __construct(
        private Thread $thread
    ) {
    }

    public function handle()
    {
        $this->thread->delete();
    }
}
