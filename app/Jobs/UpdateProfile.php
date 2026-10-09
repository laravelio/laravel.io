<?php

namespace App\Jobs;

use App\Events\EmailAddressWasChanged;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

final class UpdateProfile
{
    private array $attributes;

    public function __construct(
        private User $user,
        array $attributes = [],
        private ?UploadedFile $heroImage = null,
        private bool $deleteHeroImage = false,
        private ?UploadedFile $profilePicture = null,
        private bool $deleteProfilePicture = false,
    ) {
        $this->attributes = Arr::only($attributes, [
            'name', 'email', 'username', 'github_username', 'bio', 'twitter', 'bluesky', 'website', 'hero_image_path', 'profile_picture_path',
        ]);
    }

    public static function fromRequest(User $user, UpdateProfileRequest $request): self
    {
        return new self(
            $user,
            [
                'name' => $request->name(),
                'email' => $request->email(),
                'username' => strtolower($request->username()),
                'bio' => trim(strip_tags($request->bio())),
                'twitter' => $request->twitter(),
                'bluesky' => $request->bluesky(),
                'website' => $request->website(),
            ],
            $request->heroImage(),
            $request->shouldDeleteHeroImage(),
            $request->profilePicture(),
            $request->shouldDeleteProfilePicture(),
        );
    }

    public function handle(): void
    {
        $emailAddress = $this->user->emailAddress();
        $oldHeroImagePath = $this->user->heroImagePath();
        $oldProfilePicturePath = $this->user->profilePicturePath();

        if ($this->heroImage) {
            $this->attributes['hero_image_path'] = $this->heroImage->store('profile-hero-images', 'public');
        } elseif ($this->deleteHeroImage) {
            $this->attributes['hero_image_path'] = null;
        }

        if ($this->profilePicture) {
            $this->attributes['profile_picture_path'] = $this->profilePicture->store('profile-pictures', 'public');
        } elseif ($this->deleteProfilePicture) {
            $this->attributes['profile_picture_path'] = null;
        }

        $this->user->update($this->attributes);

        if ($oldHeroImagePath && $oldHeroImagePath !== $this->user->heroImagePath()) {
            Storage::disk('public')->delete($oldHeroImagePath);
        }

        if ($oldProfilePicturePath && $oldProfilePicturePath !== $this->user->profilePicturePath()) {
            Storage::disk('public')->delete($oldProfilePicturePath);
        }

        if ($emailAddress !== $this->user->emailAddress()) {
            $this->user->email_verified_at = null;
            $this->user->save();

            event(new EmailAddressWasChanged($this->user));
        }
    }
}
