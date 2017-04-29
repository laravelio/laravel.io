<?php

namespace App\Policies;

use App\User;

class UserPolicy
{
    const ADMIN = 'admin';
    const BAN = 'ban';
    const DELETE = 'delete';

    /**
     * Determine if the current logged in user can see the admin section.
     */
    public function admin(User $user): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine if the current logged in user can ban a user.
     */
    public function ban(User $user, User $subject): bool
    {
        return ($user->isAdmin() && ! $subject->isAdmin()) ||
            ($user->isModerator() && ! $subject->isAdmin() && ! $subject->isModerator());
    }

    /**
     * Determine if the current logged in user can delete a user.
     */
    public function delete(User $user, User $subject): bool
    {
        return $user->isAdmin() && ! $subject->isAdmin();
    }
}
