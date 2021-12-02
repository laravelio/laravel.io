<?php

namespace App\Jobs;

use App\Models\User;

final class DeleteUser
{
    public function __construct(
        private User $user
    ) {
    }

    public function handle()
    {
        $this->user->delete();
    }
}
