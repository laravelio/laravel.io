<?php

namespace App\Validation;

use Auth;

class RequiredHasPassword
{
    const NAME = 'required_has_password';

    public function validate($attribute, $value): bool
    {
        $password = Auth::user()->getAuthPassword();

        return empty($password);
    }
}
