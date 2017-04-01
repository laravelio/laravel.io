<?php

namespace App\Jobs;

use App\Exceptions\CannotCreateUser;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegisterUser
{
    /**
     * @var \App\Http\Requests\RegisterRequest
     */
    public $request;

    public function __construct(RegisterRequest $request)
    {
        $this->request = $request;
    }

    public function handle(): User
    {
        $this->assertEmailAddressIsUnique($this->request->emailAddress());
        $this->assertUsernameIsUnique($this->request->username());

        $user = new User;
        $user->name = $this->request->name();
        $user->email = $this->request->emailAddress();
        $user->username = $this->request->username();
        $user->password = $this->request->password();
        $user->ip = $this->request->ip();
        $user->github_id = $this->request->githubId();
        $user->github_url = $this->request->githubUsername();
        $user->confirmation_code = str_random(60);
        $user->type = User::DEFAULT;
        $user->save();

        return $user;
    }

    private function assertEmailAddressIsUnique(string $emailAddress)
    {
        try {
            User::findByEmailAddress($emailAddress);
        } catch (ModelNotFoundException $exception) {
            return true;
        }

        throw CannotCreateUser::duplicateEmailAddress($emailAddress);
    }

    private function assertUsernameIsUnique(string $username)
    {
        try {
            User::findByUsername($username);
        } catch (ModelNotFoundException $exception) {
            return true;
        }

        throw CannotCreateUser::duplicateUsername($username);
    }
}
