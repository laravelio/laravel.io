<?php namespace Lio\Accounts;

interface UserCreatorObserver
{
    public function userValidationError($errors);
    public function userSuccessfullyCreated($user);
}