<?php

namespace App\Jobs;

use App\User;
use App\Exceptions\CannotCreateUser;
use App\Http\Requests\RegisterRequest;
use Illuminate\Contracts\Hashing\Hasher;
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
     * @var string
     */
    private $password;

    /**
     * @var array
     */
    private $attributes;

    public function __construct(string $name, string $email, string $username, string $ip, string $password, array $attributes = [])
    {
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->ip = $ip;
        $this->password = $password;
        $this->attributes = array_only($attributes, ['github_id', 'github_url']);
    }

    public static function fromRequest(RegisterRequest $request): self
    {
        return new static(
            $request->name(),
            $request->emailAddress(),
            $request->username(),
            $request->ip(),
            $request->password(),
            ['github_id' => $request->githubId(), 'github_url' => $request->githubUsername()]
        );
    }

    public function handle(Hasher $hasher): User
    {
        $this->assertEmailAddressIsUnique($this->email);
        $this->assertUsernameIsUnique($this->username);

        $user = new User(array_merge([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'ip' => $this->ip,
            'password' => $this->password ? $hasher->make($this->password) : '',
            'confirmation_code' => str_random(60),
            'type' => User::DEFAULT,
            'remember_token' => '',
        ], $this->attributes));
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
