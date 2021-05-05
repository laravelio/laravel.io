<?php

namespace App\Http\Requests;

use App\Rules\PasscheckRule;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends Request
{
    public function rules()
    {
        return [
            'current_password' => ['sometimes', 'required', new PasscheckRule()],
            'password' => ['required', 'confirmed', Password::min(8)->uncompromised()],
        ];
    }

    public function newPassword(): string
    {
        return $this->get('password');
    }
}
