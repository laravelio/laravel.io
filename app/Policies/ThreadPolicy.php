<?php

namespace App\Policies;

use App\User;
use App\Models\Thread;

class ThreadPolicy
{
    const UPDATE = 'update';
    const DELETE = 'delete';

    /**
     * Determine if the given thread can be updated by the user.
     */
    public function update(User $user, Thread $thread): bool
    {
        return $thread->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    /**
     * Determine if the given thread can be deleted by the user.
     */
    public function delete(User $user, Thread $thread): bool
    {
        return $thread->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }
}
