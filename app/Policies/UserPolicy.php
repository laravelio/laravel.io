<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the current logged in user can administrate the portal.
     */
    public function admin(User $user): bool
    {
        return $user->isAdmin();
    }
}
