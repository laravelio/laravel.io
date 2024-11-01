<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reason' => 'required|string',
            'delete_threads' => 'required|boolean',
        ];
    }

    public function reason(): string
    {
        return $this->get('reason');
    }
}
