<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\Thread;

class MarkThreadSolution
{
    /**
     * @var \App\Models\Thread
     */
    private $thread;

    /**
     * @var \App\Models\Reply
     */
    private $solution;

    public function __construct(Thread $thread, Reply $solution)
    {
        $this->thread = $thread;
        $this->solution = $solution;
    }

    public function handle()
    {
        $this->thread->markSolution($this->solution);
    }
}
