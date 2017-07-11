<?php

namespace App\Http\Requests;

class UpdatePasswordRequest extends Request
{
    public function rules()
    {
        return [
            'current_password' => 'required_has_password|passcheck',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function newPassword(): string
    {
        return $this->get('password');
    }
}
