<?php

namespace App\Users;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Users\Exceptions\CannotCreateUser;
use Illuminate\Support\Str;

class UserRepository
{
    /**
     * @var \App\Users\User
     */
    private $model;

    public function __construct(User $model)
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

    public function findByGithubId(string $githubId): User
    {
        return $this->model->where('github_id', $githubId)->firstOrFail();
    }

    public function create(NewUserData $data): User
    {
        $this->assertEmailAddressIsUnique($data->emailAddress());
        $this->assertUsernameIsUnique($data->username());

        $user = $this->model->newInstance();
        $user->name = $data->name();
        $user->email = $data->emailAddress();
        $user->username = $data->username();
        $user->password = $data->password();
        $user->ip = $data->ip();
        $user->github_id = $data->githubId();
        $user->github_url = $data->githubUsername();
        $user->confirmation_code = Str::random(40);
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

    public function confirmUser(User $user)
    {
        $user->update(['confirmed' => true, 'confirmation_code' => null]);
    }
}
