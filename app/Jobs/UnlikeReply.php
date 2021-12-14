<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\User;

final class UnlikeReply
{
    public function __construct(
        private Reply $reply,
        private User $user
    ) {
    }

    public function handle(): void
    {
        $this->reply->dislikedBy($this->user);
    }
}
