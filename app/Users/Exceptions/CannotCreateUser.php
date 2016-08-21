<?php

namespace App\Users\Exceptions;

class CannotCreateUser extends \Exception
{
    public static function duplicateEmailAddress(string $emailAddress): CannotCreateUser
    {
        return new static("The email address [$emailAddress] already exists.");
    }

    public static function duplicateUsername(string $username): CannotCreateUser
    {
        return new static("The username [$username] already exists.");
    }
}
