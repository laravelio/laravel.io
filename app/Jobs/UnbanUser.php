<?php

namespace App\Jobs;

use App\Models\User;

final class UnbanUser
{
    public function __construct(
        private User $user
    ) {
    }

    public function handle(): User
    {
        $this->user->banned_at = null;
        $this->user->save();

        return $this->user;
    }
}
