<?php

namespace App\Validation;

use Auth;
use Hash;

class PasscheckRule
{
    const NAME = 'passcheck';

    public function validate($attribute, $value): bool
    {
        $password = Auth::user()->getAuthPassword();

        return empty($password) || Hash::check($value, $password);
    }
}
