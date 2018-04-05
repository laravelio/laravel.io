<?php

namespace App\Validation;

final class HttpImageRule
{
    const NAME = 'httpimage';
    const HTTP_IMAGE_REGEX = '/!\[.*\]\(http:\/\/.*\)/';

    public function validate($attribute, $value): bool
    {
        return ! preg_match(static::HTTP_IMAGE_REGEX, $value);
    }
}
