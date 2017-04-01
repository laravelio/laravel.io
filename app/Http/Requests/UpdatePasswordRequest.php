<?php

namespace App\Http\Requests;

use App\Validation\PasscheckRule;
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
            'current_password' => 'required|'.PasscheckRule::NAME,
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function newPassword(): string
    {
        return $this->get('password');
    }

    public function changed(): array
    {
        return ['password' => bcrypt($this->get('password'))];
    }
}
