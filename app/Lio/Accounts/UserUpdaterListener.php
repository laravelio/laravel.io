<?php namespace Lio\Accounts;

interface UserUpdaterListener
{
    public function userValidationError($errors);
    public function userUpdated($user, $emailChanged = false);
}