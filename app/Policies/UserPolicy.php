<?php

namespace App\Policies;

use App\Enums\UserPolicyAction;
use App\Models\User;

final class UserPolicy
{
    const ADMIN = UserPolicyAction::ADMIN;
    const BAN = UserPolicyAction::BAN;
    const DELETE = UserPolicyAction::DELETE;

    public function admin(User $user): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    public function ban(User $user, User $subject): bool
    {
        return ($user->isAdmin() && ! $subject->isAdmin()) ||
            ($user->isModerator() && ! $subject->isAdmin() && ! $subject->isModerator());
    }

    public function delete(User $user, User $subject): bool
    {
        return ($user->isAdmin() || $user->is($subject)) && ! $subject->isAdmin();
    }
}
