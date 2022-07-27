<?php

namespace App\Policies;

use App\Models\User;

final class UserPolicy
{
    const ADMIN = 'admin';

    const BAN = 'ban';

    const BLOCK = 'block';

    const DELETE = 'delete';

    public function admin(User $user): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    public function ban(User $user, User $subject): bool
    {
        return ($user->isAdmin() && ! $subject->isAdmin()) ||
            ($user->isModerator() && ! $subject->isAdmin() && ! $subject->isModerator());
    }

    public function block(User $user, User $subject): bool
    {
        return ! $user->is($subject) && ! $subject->isModerator() && ! $subject->isAdmin();
    }

    public function delete(User $user, User $subject): bool
    {
        return ($user->isAdmin() || $user->is($subject)) && ! $subject->isAdmin();
    }
}
