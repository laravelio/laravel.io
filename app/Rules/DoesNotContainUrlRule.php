<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

final class DoesNotContainUrlRule implements ValidationRule
{
    use ValidatesAttributes;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fails = collect(explode(' ', $value))->contains(function ($word) {
            return $this->validateRequired('word', $word) && $this->validateUrl('word', $word);
        });

        if ($fails) {
            $fail('The :attribute field cannot contain an url.');
        }
    }
}
