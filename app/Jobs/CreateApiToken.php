<?php

namespace App\Jobs;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

final class CreateApiToken
{
    public function __construct(private User $user, private string $name)
    {
    }

    public function handle(): NewAccessToken
    {
        return $this->user->createToken($this->name);
    }
}
