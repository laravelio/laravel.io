<?php

namespace App\Jobs;

use App\Exceptions\CannotLockItem;
use App\Models\Thread;
use App\Models\User;

final class LockThread
{
    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * @var \App\Models\Thread
     */
    private $thread;

    public function __construct(User $user, Thread $thread)
    {
        $this->user = $user;
        $this->thread = $thread;
    }

    public function handle()
    {
        if ($this->thread->isLocked()) {
            throw CannotLockItem::alreadyLocked('thread');
        }

        $this->thread->lockedBy($this->user);
    }
}
