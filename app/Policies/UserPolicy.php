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
        if ($subject->isAdmin()) {
            return false;
        }

        return $user->isAdmin() || ($user->isModerator() && ! $subject->isModerator());
    }

    public function block(User $user, User $subject): bool
    {
        return ! $user->is($subject) && $subject->isRegularUser();
    }

    public function delete(User $user, User $subject): bool
    {
        return ($user->isAdmin() || $user->is($subject)) && ! $subject->isAdmin();
    }
}
