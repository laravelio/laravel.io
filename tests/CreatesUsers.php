<?php

namespace Tests;

use App\Users\User;

trait CreatesUsers
{
    protected function login(array $attributes = []): User
    {
        $user = $this->createUser($attributes);

        $this->be($user);

        return $user;
    }

    protected function createUser(array $attributes = []): User
    {
        return $this->create(User::class, array_merge([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'github_url' => 'johndoe',
        ], $attributes));
    }
}
