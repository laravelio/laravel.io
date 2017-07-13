<?php

namespace App\Jobs;

use App\User;
use App\Models\Thread;

class ToggleThreadSubscription
{
    /**
     * @var \App\Models\Thread
     */
    private $thread;

    /**
     * @var \App\User
     */
    private $user;

    public function __construct(Thread $thread, User $user)
    {
        $this->thread = $thread;
        $this->user = $user;
    }

    public function handle()
    {
        $this->thread->subscribers()->toggle($this->user);
    }
}
