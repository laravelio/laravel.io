<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * This rule validates links are not diguised as mentions.
 */
final class InvalidMentionRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return ! preg_match('/\[@.*\]\(http.*\)/', $value);
    }

    public function message(): string
    {
        return 'The :attribute field contains an invalid mention.';
    }
}
