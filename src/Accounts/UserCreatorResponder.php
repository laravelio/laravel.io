<?php namespace Lio\Accounts;

interface UserCreatorResponder
{
    public function userValidationError($errors);
    public function userCreated($user);
}
