<?php

namespace Lio\Replies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Lio\Users\User;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given reply can be updated by the user.
     */
    public function update(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user);
    }

    /**
     * Determine if the given reply can be deleted by the user.
     */
    public function delete(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user);
    }
}
