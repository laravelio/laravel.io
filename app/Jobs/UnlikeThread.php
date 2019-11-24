<?php

namespace App\Jobs;

use App\User;
use App\Models\Thread;

class UnlikeThread
{
    /**
     * @var \App\Models\Thread
     */
    private $thread;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Thread $thread
     * @param \App\User $user
     */
    public function __construct(Thread $thread, User $user)
    {
        $this->thread = $thread;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->thread->dislikedBy($this->user);
    }
}
