<?php

namespace App\Jobs;

use App\Exceptions\CannotLikeItem;
use App\Models\Thread;
use App\Models\User;

final class LikeThread
{
    public function __construct(
        private Thread $thread,
        private User $user
    ) {
    }

    /**
     * @throws \App\Exceptions\CannotLikeItem
     */
    public function handle(): void
    {
        if ($this->thread->isLikedBy($this->user)) {
            throw CannotLikeItem::alreadyLiked('thread');
        }

        $this->thread->likedBy($this->user);
    }
}
