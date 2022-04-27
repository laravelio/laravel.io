<?php

namespace App\Jobs;

use App\Models\User;

final class DeleteUser
{
    public function __construct(private User $user)
    {
    }

    public function handle(): void
    {
        $this->user->delete();
    }
}
