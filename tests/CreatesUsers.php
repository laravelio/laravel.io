<?php

namespace Tests;

use App\Models\User;

trait CreatesUsers
{
    protected function login(array $attributes = []): User
    {
        $user = $this->createUser($attributes);

        $this->be($user);

        return $user;
    }

    protected function loginAs(User $user)
    {
        $this->be($user);
    }

    protected function loginAsModerator(array $attributes = []): User
    {
        return $this->login(array_merge($attributes, ['type' => User::MODERATOR]));
    }

    protected function loginAsAdmin(array $attributes = []): User
    {
        return $this->login(array_merge($attributes, ['type' => User::ADMIN]));
    }

    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'github_username' => 'johndoe',
        ], $attributes));
    }
}
