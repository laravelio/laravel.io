<?php

namespace App\Http\Requests;

use App\Rules\PasscheckRule;

class UpdatePasswordRequest extends Request
{
    public function rules()
    {
        return [
            'current_password' => ['sometimes', 'required', new PasscheckRule],
            'password' => 'required|confirmed|min:8',
        ];
    }

    public function newPassword(): string
    {
        return $this->get('password');
    }
}
