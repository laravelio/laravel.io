<?php

namespace App\Jobs;

use App\Models\User;

final class UnblockUser
{
    public function __construct(private User $user, private User $blockedUser)
    {
    }

    public function handle(): void
    {
        $this->user->blockedUsers()->detach($this->blockedUser);
    }
}
