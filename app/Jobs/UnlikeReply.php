<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\User;

final class UnlikeReply
{
    /**
     * @var \App\Models\Reply
     */
    private $reply;

    /**
     * @var \App\Models\User
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
