<?php
namespace Lio\Users;

use Illuminate\Database\QueryException;
use Lio\Users\Exceptions\UserCreationException;

final class EloquentUserRepository implements UserRepository
{
    /**
     * @var \Lio\Users\EloquentUser
     */
    private $model;

    /**
     * @param \Lio\Users\EloquentUser $model
     */
    public function __construct(EloquentUser $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $username
     * @return \Lio\Users\User|null
     */
    public function findByUsername($username)
    {
        return $this->model->where('username', $username)->first();
    }

    /**
     * @param string $emailAddress
     * @return \Lio\Users\User|null
     */
    public function findByEmailAddress($emailAddress)
    {
        return $this->model->where('email', $emailAddress)->first();
    }

    /**
     * @param string $name
     * @param string $emailAddress
     * @param string $password
     * @param string $username
     * @param array $attributes
     * @return \Lio\Users\User
     * @throws \Lio\Users\Exceptions\UserCreationException
     */
    public function create($name, $emailAddress, $password, $username, array $attributes = [])
    {
        if ($this->findByEmailAddress($emailAddress)) {
            throw UserCreationException::duplicateEmailAddress($emailAddress);
        }

        if ($this->findByUsername($username)) {
            throw UserCreationException::duplicateUsername($username);
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
