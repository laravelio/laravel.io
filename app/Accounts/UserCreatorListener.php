<?php

namespace Lio\Accounts;

interface UserCreatorListener
{
    public function userValidationError($errors);

    public function userCreated($user);
}
