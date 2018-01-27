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
            'company' => 'nullable|string|max:255',
            'job_title' => 'required_with:company',
            'mobile' => 'nullable|string',
            'keep_mobile_private' => 'boolean',
            'twitter_username' => 'nullable|string',
            'list_on_public_directory' => 'boolean',
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

    public function company(): string
    {
        return (string) $this->get('company');
    }

    public function jobTitle(): string
    {
        return (string) $this->get('job_title');
    }


    public function listOnPublicDirectory(): bool
    {
        return (bool) $this->get('list_on_public_directory', false);
    }

    public function mobile(): string
    {
        return (string) $this->get('mobile');
    }

    public function twitterUsername(): string
    {
        return (string) $this->get('twitter_username');
    }

    public function mobileKepPrivately()
    {
        return (bool) $this->get('keep_mobile_private', false);
    }
}
