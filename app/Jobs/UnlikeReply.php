<?php

namespace App\Jobs;

use App\Models\Reply;
use App\User;

class UnlikeReply
{
    /**
     * @var \App\Models\Reply
     */
    private $reply;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Reply $reply
     * @param \App\User $user
     */
    public function __construct(Reply $reply, User $user)
    {
        $this->reply = $reply;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->reply->dislikedBy($this->user);
    }
}
