<?php

namespace App\Users;

interface UserRepository
{
    public function findByUsername(string $username): User;
    public function findByEmailAddress(string $emailAddress): User;
    public function create(string $name, string $emailAddress, string $password, string $username, array $attributes = []): User;
    public function update(User $user, array $attributes): User;
    public function confirmUser(User $user);
}
