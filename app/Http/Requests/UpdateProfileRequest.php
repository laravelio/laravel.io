<?php

namespace App\Http\Requests;

use Auth;

class UpdateProfileRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::id(),
            'username' => 'required|max:255|unique:users,username,'.Auth::id(),
            'bio' => 'max:160',
        ];
    }

    public function bio(): string
    {
        return (string) $this->get('bio', '');
    }

    public function name(): string
    {
        return (string) $this->get('name');
    }

    public function email(): string
    {
        return (string) $this->get('email');
    }

    public function username(): string
    {
        return (string) $this->get('username');
    }
}
