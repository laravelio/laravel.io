<?php

namespace App\Users;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Users\Exceptions\CannotCreateUser;

final class EloquentUserRepository implements UserRepository
{
    /**
     * @var \App\Users\EloquentUser
     */
    private $model;

    public function __construct(EloquentUser $model)
    {
        $this->model = $model;
    }

    public function findByUsername(string $username): User
    {
        return $this->model->where('username', $username)->firstOrFail();
    }

    public function findByEmailAddress(string $emailAddress): User
    {
        return $this->model->where('email', $emailAddress)->firstOrFail();
    }

    public function create(string $name, string $emailAddress, string $password, string $username, array $attributes = []): User
    {
        $this->assertEmailAddressIsUnique($emailAddress);
        $this->assertUsernameIsUnique($username);

        $user = $this->model->newInstance($attributes);
        $user->name = $name;
        $user->email = $emailAddress;
        $user->password = $password;
        $user->username = $username;
        $user->save();

        return $user;
    }

    private function assertEmailAddressIsUnique(string $emailAddress)
    {
        try {
            $this->findByEmailAddress($emailAddress);
        } catch (ModelNotFoundException $exception) {
            return true;
        }

        throw CannotCreateUser::duplicateEmailAddress($emailAddress);
    }

    private function assertUsernameIsUnique(string $username)
    {
        try {
            $this->findByUsername($username);
        } catch (ModelNotFoundException $exception) {
            return true;
        }

        throw CannotCreateUser::duplicateUsername($username);
    }

    public function update(User $user, array $attributes): User
    {
        $user->update($attributes);

        return $user;
    }
}
