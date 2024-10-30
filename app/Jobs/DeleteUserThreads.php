<?php

namespace App\Jobs;

use App\Models\User;

final class DeleteUserThreads
{
    public function __construct(private User $user) {}

    public function handle(): void
    {
        $this->user->deleteThreads();
    }
}
