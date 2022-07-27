<?php

namespace App\Jobs;

use App\Models\User;

final class BlockUser
{
    public function __construct(private User $user, private User $blockedUser)
    {
    }

    public function handle(): void
    {
        $this->user->blockedUsers()->attach($this->blockedUser);
    }
}
