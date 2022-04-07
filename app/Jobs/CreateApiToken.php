<?php

namespace App\Jobs;

use App\Models\User;

final class CreateApiToken
{
    public function __construct(private User $user, private string $name)
    {
    }

    public function handle(): void
    {
        $this->user->createToken($this->name);
    }
}
