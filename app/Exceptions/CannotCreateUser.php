<?php

namespace App\Exceptions;

use Exception;

class CannotCreateUser extends Exception
{
    public static function duplicateEmailAddress(string $emailAddress): self
    {
        return new static("The email address [$emailAddress] already exists.");
    }

    public static function duplicateUsername(string $username): self
    {
        return new static("The username [$username] already exists.");
    }
}
