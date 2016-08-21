<?php

namespace App\Forum;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Users\User;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given thread can be updated by the user.
     */
    public function update(User $user, Thread $thread): bool
    {
        return $thread->isAuthoredBy($user);
    }

    /**
     * Determine if the given thread can be deleted by the user.
     */
    public function delete(User $user, Thread $thread): bool
    {
        return $thread->isAuthoredBy($user);
    }
}
