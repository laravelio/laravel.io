<?php

namespace App\Validation;

use Auth;
use Hash;

final class PasscheckRule
{
    const NAME = 'passcheck';

    public function validate($attribute, $value): bool
    {
        return Hash::check($value, Auth::user()->getAuthPassword());
    }
}
