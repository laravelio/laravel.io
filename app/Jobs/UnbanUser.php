<?php

namespace App\Jobs;

use App\Models\User;

final class UnbanUser
{
    public function __construct(private User $user)
    {
    }

    public function handle(): void
    {
        $this->user->banned_at = null;
        $this->user->banned_reason = null;
        $this->user->save();
    }
}
