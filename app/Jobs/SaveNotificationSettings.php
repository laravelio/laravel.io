<?php

namespace App\Jobs;

use App\Models\User;

final class SaveNotificationSettings
{
    public function __construct(private User $user, private readonly array $allowedNotifications)
    {
    }

    public function handle(): void
    {
        $this->user->notifications = $this->allowedNotifications;
        $this->user->save();
    }
}
