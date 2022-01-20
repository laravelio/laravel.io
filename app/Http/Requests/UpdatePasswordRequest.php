<?php

namespace App\Http\Requests;

use App\Rules\PasscheckRule;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends Request
{
    public function rules()
    {
        $rules = [
            'password' => ['required', 'confirmed', Password::min(8)->uncompromised()],
        ];

        if ($this->user()->hasPassword()) {
            $rules['current_password'] = ['required', new PasscheckRule()];
        }

        return $rules;
    }

    public function newPassword(): string
    {
        return $this->get('password');
    }
}
