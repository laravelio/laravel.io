<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class PasscheckRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Hash::check($value, Auth::user()->getAuthPassword())) {
            $fail('Your current password is incorrect.');
        }
    }
}
