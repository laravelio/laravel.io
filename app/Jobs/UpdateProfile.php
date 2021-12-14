<?php

namespace App\Jobs;

use App\Events\EmailAddressWasChanged;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Arr;

final class UpdateProfile
{
    private array $attributes;

    public function __construct(
        private User $user,
        array $attributes = []
    ) {
        $this->attributes = Arr::only($attributes, ['name', 'email', 'username', 'github_username', 'bio', 'twitter']);
    }

    public static function fromRequest(User $user, UpdateProfileRequest $request): self
    {
        return new static($user, [
            'name' => $request->name(),
            'email' => $request->email(),
            'username' => strtolower($request->username()),
            'bio' => trim(strip_tags($request->bio())),
            'twitter' => $request->twitter(),
        ]);
    }

    public function handle(): User
    {
        $emailAddress = $this->user->emailAddress();

        $this->user->update($this->attributes);

        if ($emailAddress !== $this->user->emailAddress()) {
            $this->user->email_verified_at = null;
            $this->user->save();

            event(new EmailAddressWasChanged($this->user));
        }

        return $this->user;
    }
}
