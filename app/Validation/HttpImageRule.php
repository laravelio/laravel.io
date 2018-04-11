<?php

namespace App\Validation;

/**
 * This rule validates Markdown for non-HTTPS image links.
 */
final class HttpImageRule
{
    const NAME = 'httpimage';

    public function validate($attribute, $value): bool
    {
        return ! preg_match('/!\[.*\]\(http:\/\/.*\)/', $value);
    }
}
