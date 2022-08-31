<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function deleting(User $user)
    {
        $user->replyAble()->forceDelete();
    }
}
