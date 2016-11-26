<?php

namespace App\Http\Requests;

use Auth;

class UpdatePasswordRequest extends Request
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'current_password' => 'required|passcheck',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function changed(): array
    {
        return ['password' => bcrypt($this->get('password'))];
    }
}
