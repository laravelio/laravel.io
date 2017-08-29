<?php

namespace App\Jobs;

use App\User;
use App\Exceptions\CannotCreateUser;
use App\Http\Requests\RegisterRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegisterUser
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @var string
     */
    private $githubId;

    /**
     * @var string
     */
    private $githubUsername;

    public function __construct(string $name, string $email, string $username, string $ip, string $githubId, string $githubUsername)
    {
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->ip = $ip;
        $this->githubId = $githubId;
        $this->githubUsername = $githubUsername;
    }

    public static function fromRequest(RegisterRequest $request): self
    {
        return new static(
            $request->name(),
            $request->emailAddress(),
            $request->username(),
            $request->ip(),
            $request->githubId(),
            $request->githubUsername()
        );
    }

    public function handle(): User
    {
        $this->assertEmailAddressIsUnique($this->email);
        $this->assertUsernameIsUnique($this->username);

        $user = new User([
            'name' => $this->name,
            'email' => $this->email,
            'username' => strtolower($this->username),
            'ip' => $this->ip,
            'github_id' => $this->githubId,
            'github_username' => $this->githubUsername,
            'confirmation_code' => str_random(60),
            'type' => User::DEFAULT,
            'remember_token' => '',
        ]);
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
