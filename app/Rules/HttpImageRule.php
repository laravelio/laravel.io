<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * This rule validates Markdown for non-HTTPS image links.
 */
final class HttpImageRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('/!\[.*\]\(http:\/\/.*\)/', $value)) {
            $fail('The :attribute field contains at least one image with an HTTP link.');
        }
    }
}
