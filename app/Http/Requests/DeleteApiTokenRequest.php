<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteApiTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:personal_access_tokens,id'],
        ];
    }

    public function id(): string
    {
        return (string) $this->get('id');
    }
}
