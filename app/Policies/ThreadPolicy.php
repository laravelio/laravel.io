<?php

namespace App\Policies;

use App\Enums\ThreadPolicyAction;
use App\Models\Thread;
use App\Models\User;

final class ThreadPolicy
{
    const UPDATE = ThreadPolicyAction::UPDATE;
    const DELETE = ThreadPolicyAction::DELETE;
    const SUBSCRIBE = ThreadPolicyAction::SUBSCRIBE;
    const UNSUBSCRIBE = ThreadPolicyAction::UNSUBSCRIBE;

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
}
