<?php

namespace App\Http\Requests;

use App\Validation\PasscheckRule;

class UpdatePasswordRequest extends Request
{
    public function rules()
    {
        return [
            'current_password' => 'sometimes|required|'.PasscheckRule::NAME,
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function newPassword(): string
    {
        return $this->get('password');
    }
}
