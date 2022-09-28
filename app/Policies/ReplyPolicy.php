<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

final class ReplyPolicy
{
    const CREATE = 'create';

    const UPDATE = 'update';

    const DELETE = 'delete';

    const REPORT_SPAM = 'reportSpam';

    /**
     * Determine if replies can be created by the user.
     */
    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine if the given reply can be updated by the user.
     */
    public function update(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    /**
     * Determine if the given reply can be deleted by the user.
     */
    public function delete(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function reportSpam(User $user, Reply $reply): bool
    {
        if ($reply->author()->isModerator() || $reply->author()->isAdmin()) {
            return false;
        }

        return ! $reply->spamReportersRelation()->where('reporter_id', $user->id)->count() &&
            $reply->author()->isNot($user);
    }
}
