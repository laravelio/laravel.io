<?php

namespace Lio\Users;

use Lio\Users\Exceptions\CannotCreateUser;

final class EloquentUserRepository implements UserRepository
{
    /**
     * @var \Lio\Users\EloquentUser
     */
    private $model;

    public function __construct(EloquentUser $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Lio\Users\User|null
     */
    public function findByUsername(string $username)
    {
        return $this->model->where('username', $username)->first();
    }

    /**
     * @return \Lio\Users\User|null
     */
    public function findByEmailAddress(string $emailAddress)
    {
        return $this->model->where('email', $emailAddress)->first();
    }

    public function create(string $name, string $emailAddress, string $password, string $username, array $attributes = []): User
    {
        if ($this->findByEmailAddress($emailAddress)) {
            throw CannotCreateUser::duplicateEmailAddress($emailAddress);
        }

        if ($this->findByUsername($username)) {
            throw CannotCreateUser::duplicateUsername($username);
        }

        $user = $this->model->newInstance($attributes);
        $user->name = $name;
        $user->email = $emailAddress;
        $user->password = $password;
        $user->username = $username;
        $user->save();

        return $user;
    }
}
