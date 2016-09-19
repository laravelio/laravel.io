<?php

namespace App\Users;

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

    public function __construct($name, $emailAddress, $username, $password = null, $ip = null, $githubId = null)
    {
        $this->name = $name;
        $this->emailAddress = $emailAddress;
        $this->username = $username;
        $this->password = $password;
        $this->ip = $ip;
        $this->githubId = $githubId;
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
}
