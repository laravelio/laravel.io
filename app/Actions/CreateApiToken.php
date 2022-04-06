<?php

namespace App\Actions;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

final class CreateApiToken
{
    public function create(User $user, string $name): NewAccessToken
    {
        return $user->createToken($name);
    }
}
