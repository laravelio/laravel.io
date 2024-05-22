<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * This rule validates links are not diguised as mentions.
 */
final class InvalidMentionRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('/\[@.*\]\(http.*\)/', $value)) {
            $fail('The :attribute field contains an invalid mention.');
        }
    }
}
