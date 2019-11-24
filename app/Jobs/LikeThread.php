<?php

namespace App\Jobs;

use App\Exceptions\CannotLikeThreadMultipleTimes;
use App\Models\Thread;
use App\User;
use Illuminate\Database\QueryException;

class LikeThread
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
     * @throws \App\Exceptions\CannotLikeReplyTwice
     */
    public function handle()
    {
        try {
            $this->thread->likedBy($this->user);
        } catch (QueryException $exception) {
            throw new CannotLikeThreadMultipleTimes();
        }
    }
}
