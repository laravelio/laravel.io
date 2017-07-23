<?php

namespace App\Validation;

use Auth;

class RequiredUnlessNoPassword
{
    const NAME = 'required_unless_no_password';

    public function validate($attribute, $value): bool
    {
        $password = Auth::user()->getAuthPassword();

        return empty($password) || ! empty($value);
    }
}
