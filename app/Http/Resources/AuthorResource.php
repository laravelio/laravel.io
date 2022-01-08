<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class AuthorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->getKey(),
            'email' => $this->emailAddress(),
            'username' => $this->username(),
            'name' => $this->name(),
            'bio' => $this->bio(),
            'twitter_handle' => $this->twitter(),
            'github_username' => $this->githubUsername(),
        ];
    }
}
