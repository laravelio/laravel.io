<?php

namespace App\Policies;

use App\Models\Series;
use App\Models\User;

final class SeriesPolicy
{
    const UPDATE = 'update';
    const DELETE = 'delete';

    public function update(User $user, Series $series): bool
    {
        return $series->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function delete(User $user, Series $series): bool
    {
        return $series->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }
}
