<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Session;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:40|unique:users',
        ];

        if (Session::has('githubData')) {
            $rules['password'] = 'confirmed|min:6';
        } else {
            $rules['password'] = 'required|confirmed|min:6';
        }

        return $rules;
    }

    public function name(): string
    {
        return $this->get('name');
    }

    public function emailAddress(): string
    {
        return $this->get('email');
    }

    public function username(): string
    {
        return $this->get('username');
    }

    public function password(): string
    {
        return $this->get('password', '');
    }

    public function githubId(): string
    {
        return session('githubData.id', '');
    }

    public function githubUsername(): string
    {
        return session('githubData.username', '');
    }
}
