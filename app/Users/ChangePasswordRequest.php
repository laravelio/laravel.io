<?php

namespace Lio\Users;

use Auth;
use Lio\Http\Requests\Request;

class ChangePasswordRequest extends Request
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

    public function dataForUpdate(): array
    {
        return ['password' => bcrypt($this->get('password'))];
    }
}
