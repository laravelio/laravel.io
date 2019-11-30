<?php

namespace App\Jobs;

use App\Exceptions\CannotLikeItem;
use App\Models\Thread;
use App\User;

final class LikeThread
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
