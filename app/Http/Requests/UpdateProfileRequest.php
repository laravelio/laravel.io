<?php

namespace App\Http\Requests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::id(),
            'username' => 'required|alpha_dash|max:255|unique:users,username,'.Auth::id(),
            'twitter' => 'max:255|nullable|unique:users,twitter,'.Auth::id(),
            'bluesky' => 'max:255|nullable|unique:users,bluesky,'.Auth::id(),
            'website' => 'max:255|nullable|url',
            'bio' => 'max:160',
            'hero_image' => 'nullable|image|max:4096',
            'delete_hero_image' => 'nullable|boolean',
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

    public function twitter(): ?string
    {
        return $this->get('twitter');
    }

    public function bluesky(): ?string
    {
        return $this->get('bluesky');
    }

    public function website(): ?string
    {
        return $this->get('website');
    }

    public function heroImage(): ?UploadedFile
    {
        $file = $this->file('hero_image');

        return $file instanceof UploadedFile ? $file : null;
    }

    public function shouldDeleteHeroImage(): bool
    {
        return $this->boolean('delete_hero_image');
    }
}
