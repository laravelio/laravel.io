<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->getKey(),
            'email' => $this->emailAddress(),
            'name' => $this->name(),
            'bio' => $this->bio(),
            'twitter_handle' => $this->twitter(),
            'github_username' => $this->githubUsername(),
        ];
    }
}
