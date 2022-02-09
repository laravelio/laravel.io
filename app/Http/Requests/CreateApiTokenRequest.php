<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateApiTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token_name' => ['required', 'string', 'max:255'],
        ];
    }

    public function name(): string
    {
        return (string) $this->get('token_name');
    }
}
