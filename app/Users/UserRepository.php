<?php

namespace Lio\Users;

interface UserRepository
{
    /**
     * @return \Lio\Users\User|null
     */
    public function findByUsername(string $username);

    /**
     * @return \Lio\Users\User|null
     */
    public function findByEmailAddress(string $emailAddress);

    public function create(string $name, string $emailAddress, string $password, string $username, array $attributes = []): User;
}
