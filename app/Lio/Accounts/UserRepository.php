<?php namespace Lio\Accounts;

use Lio\Core\EloquentRepository;
use Lio\Core\Exceptions\EntityNotFoundException;

class UserRepository extends EloquentRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getByGithubId($id)
    {
        return $this->model->where('github_id', '=', $id)->first();
    }

    public function requireByName($name)
    {
        $model = $this->getByName($name);

        if (! $model) {
            throw new EntityNotFoundException("User with name {$name} could not be found.");
        }

        return $model;
    }

    public function getByName($name)
    {
        return $this->model->where('name', '=', $name)->first();
    }

    public function getFirstX($count)
    {
        return $this->model->take($count)->get();
    }

    /**
     * Find a user by its confirmation code
     *
     * @param string $code
     * @return \Lio\Accounts\User
     */
    public function getByConfirmationCode($code)
    {
        return $this->model->where('confirmation_code', $code)->first();
    }

    /**
     * Determine if an email already exists for a user
     *
     * @param string $email
     * @return bool
     */
    public function emailExists($email)
    {
        return (bool) User::where('email', $email)->count();
    }
}
