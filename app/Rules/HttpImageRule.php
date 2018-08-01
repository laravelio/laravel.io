<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * This rule validates Markdown for non-HTTPS image links.
 */
final class HttpImageRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return ! preg_match('/!\[.*\]\(http:\/\/.*\)/', $value);
    }

    public function message(): string
    {
        return 'The :attribute field contains at least one image with an HTTP link.';
    }
}
