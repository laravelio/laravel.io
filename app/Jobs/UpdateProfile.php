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
    ) {
        $this->attributes = Arr::only($attributes, [
            'name', 'email', 'username', 'github_username', 'bio', 'twitter', 'bluesky', 'website', 'hero_image_path',
        ]);
    }

    public static function fromRequest(User $user, UpdateProfileRequest $request): self
    {
        return new self($user, [
            'name' => $request->name(),
            'email' => $request->email(),
            'username' => strtolower($request->username()),
            'bio' => trim(strip_tags($request->bio())),
            'twitter' => $request->twitter(),
            'bluesky' => $request->bluesky(),
            'website' => $request->website(),
        ], $request->heroImage(), $request->shouldDeleteHeroImage());
    }

    public function handle(): void
    {
        $emailAddress = $this->user->emailAddress();
        $oldHeroImagePath = $this->user->heroImagePath();

        if ($this->heroImage) {
            $this->attributes['hero_image_path'] = $this->heroImage->store('profile-hero-images', $this->heroImageDisk());
        } elseif ($this->deleteHeroImage) {
            $this->attributes['hero_image_path'] = null;
        }

        $this->user->update($this->attributes);

        if ($oldHeroImagePath && $oldHeroImagePath !== $this->user->heroImagePath()) {
            Storage::disk($this->heroImageDisk())->delete($oldHeroImagePath);
        }

        if ($emailAddress !== $this->user->emailAddress()) {
            $this->user->email_verified_at = null;
            $this->user->save();

            event(new EmailAddressWasChanged($this->user));
        }
    }

    private function heroImageDisk(): string
    {
        return config('lio.profile_hero_images.disk', 'public');
    }
}
