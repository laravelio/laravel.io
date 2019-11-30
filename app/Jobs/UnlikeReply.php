<?php

namespace App\Jobs;

use App\Models\Reply;
use App\User;

final class UnlikeReply
{
    /**
     * @var \App\Models\Reply
     */
    private $reply;

    /**
     * @var \App\User
     */
    private $user;

    public function __construct(Reply $reply, User $user)
    {
        $this->reply = $reply;
        $this->user = $user;
    }

    public function handle(): void
    {
        $this->reply->dislikedBy($this->user);
    }
}
