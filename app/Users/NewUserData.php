<?php

namespace App\Users;

use Illuminate\Http\Request;
use Illuminate\Session\SessionInterface as Session;

class NewUserData
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var string|null
     */
    private $ip;

    /**
     * @var string|null
     */
    private $githubId;

    /**
     * @var string|null
     */
    private $githubUsername;

    public function __construct($name, $emailAddress, $username, $password = null, $ip = null, $githubId = null, $githubUsername = null)
    {
        $this->name = $name;
        $this->emailAddress = $emailAddress;
        $this->username = $username;
        $this->password = $password;
        $this->ip = $ip;
        $this->githubId = $githubId;
        $this->githubUsername = $githubUsername;
    }

    public static function makeFromRequestAndSession(Request $request, Session $session): NewUserData
    {
        return new self(
            $request->get('name'),
            $request->get('email'),
            $request->get('username'),
            $request->has('password') ? bcrypt($request->get('password')) : null,
            $request->ip(),
            $session->get('githubData.id'),
            $session->get('githubData.username')
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function emailAddress(): string
    {
        return $this->emailAddress;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password ?: '';
    }

    public function ip(): string
    {
        return $this->ip ?: '';
    }

    public function githubId(): string
    {
        return $this->githubId ?: '';
    }

    public function githubUsername()
    {
        return $this->githubUsername ?: '';
    }
}
