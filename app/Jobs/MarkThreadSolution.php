<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;

final class MarkThreadSolution
{
    /**
     * @var \App\Models\Thread
     */
    private $thread;

    /**
     * @var \App\Models\Reply
     */
    private $solution;

    /**
     * @var \App\Models\User
     */
    private $user;

    public function __construct(Thread $thread, Reply $solution, User $user)
    {
        $this->thread = $thread;
        $this->solution = $solution;
        $this->user = $user;
    }

    public function handle()
    {
        $this->thread->markSolution($this->solution, $this->user);
    }
}
