<?php

namespace App\Jobs;

use App\User;
use Illuminate\Support\Arr;
use App\Http\Requests\UpdateProfileRequest;

final class UpdateProfile
{
    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var array
     */
    private $attributes;

    public function __construct(User $user, array $attributes = [])
    {
        $this->user = $user;
        $this->attributes = Arr::only($attributes, ['name', 'email', 'username', 'github_username', 'bio']);
    }

    public static function fromRequest(User $user, UpdateProfileRequest $request): self
    {
        return new static($user, [
            'name' => $request->name(),
            'email' => $request->email(),
            'username' => strtolower($request->username()),
            'bio' => trim(strip_tags($request->bio())),
        ]);
    }

    public function handle(): User
    {
        $this->user->update($this->attributes);

        return $this->user;
    }
}
