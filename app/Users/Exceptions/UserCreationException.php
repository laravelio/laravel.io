<?php
namespace Lio\Users\Exceptions;

class UserCreationException extends \Exception
{
    public static function duplicateEmailAddress($emailAddress)
    {
        return new static("The email address [$emailAddress] already exists.");
    }

    public static function duplicateUsername($username)
    {
        return new static("The username [$username] already exists.");
    }
}
