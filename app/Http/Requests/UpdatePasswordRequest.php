<?php

namespace App\Http\Requests;

use App\Validation\PasscheckRule;
use Auth;

class UpdatePasswordRequest extends Request
{
    public function rules()
    {
        return [
            'current_password' => 'required|'.PasscheckRule::NAME,
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function newPassword(): string
    {
        return $this->get('password');
    }
}
