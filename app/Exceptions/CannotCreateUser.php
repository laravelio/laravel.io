<?php

namespace App\Exceptions;

use Exception;

final class CannotCreateUser extends Exception
{
    public static function duplicateEmailAddress(string $emailAddress): self
    {
        return new self("The email address [$emailAddress] already exists.");
    }

    public static function duplicateUsername(string $username): self
    {
        return new self("The username [$username] already exists.");
    }
}
