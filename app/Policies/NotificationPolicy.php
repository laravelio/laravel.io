<?php

namespace App\Policies;

use App\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    const MARK_AS_READ = 'markAsRead';

    /**
     * Determine if the given notification can be marked as read by the user.
     */
    public function markAsRead(User $user, DatabaseNotification $notification): bool
    {
        return $notification->notifiable->id() === $user->id();
    }
}
