<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;

final class ThreadPolicy
{
    const UPDATE = 'update';

    const DELETE = 'delete';

    const SUBSCRIBE = 'subscribe';

    const UNSUBSCRIBE = 'unsubscribe';

    const LOCK = 'lock';

    const REPORT_SPAM = 'reportSpam';

    public function update(User $user, Thread $thread): bool
    {
        return $thread->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function delete(User $user, Thread $thread): bool
    {
        return $thread->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function subscribe(User $user, Thread $thread): bool
    {
        return ! $thread->hasSubscriber($user);
    }

    public function unsubscribe(User $user, Thread $thread): bool
    {
        return $thread->hasSubscriber($user);
    }

    public function lock(User $user): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    public function markAsSpam(User $user, Thread $thread): bool
    {
        if ($thread->author->isModerator() || $thread->author->isAdmin()) {
            return false;
        }

        return $thread->spammers->doesntContain($user);
    }
}
