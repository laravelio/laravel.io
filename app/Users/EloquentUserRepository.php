<?php
namespace Lio\Users;

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
}
