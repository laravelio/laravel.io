<?php

namespace App\Users;

interface UserRepository
{
    public function findByUsername(string $username): User;
    public function findByEmailAddress(string $emailAddress): User;
    public function findByGithubId(string $githubId): User;
    public function create(NewUserData $data): User;
    public function update(User $user, array $attributes): User;
    public function confirmUser(User $user);
}
