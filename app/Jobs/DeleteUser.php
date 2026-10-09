<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

final class DeleteUser
{
    public function __construct(private User $user) {}

    public function handle(): void
    {
        $files = array_filter([
            $this->user->heroImagePath(),
            $this->user->profilePicturePath(),
        ]);

        $this->user->delete();

        if ($files) {
            Storage::disk('public')->delete($files);
        }
    }
}
