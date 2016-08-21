<?php

namespace App\Replies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Users\User;

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
