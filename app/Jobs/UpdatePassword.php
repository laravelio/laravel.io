<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;

final class UpdatePassword
{
    public function __construct(
        private User $user,
        private string $newPassword
    ) {
    }

    public function handle(Hasher $hasher)
    {
        $this->user->update(['password' => $hasher->make($this->newPassword)]);
    }
}
