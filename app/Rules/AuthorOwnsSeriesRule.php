<?php

namespace App\Rules;

use App\Models\Series;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Concerns\ValidatesAttributes;

final class AuthorOwnsSeriesRule implements Rule
{
    use ValidatesAttributes;

    public function passes($attribute, $value): bool
    {
        return Series::where('author_id', Auth::id())->exists();
    }

    public function message(): string
    {
        return 'The :attribute field does not belong to you.';
    }
}
