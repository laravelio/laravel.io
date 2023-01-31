<?php

namespace App\Jobs;

use App\Models\User;
use App\Enums\NotificationTypes;

final class SaveNotificationSettings
{
    public function __construct(private User $user, private readonly array $allowedNotifications)
    {
    }

    public function handle(): void
    {
        $types = NotificationTypes::getTypes();
        $not_allowed_notifications = array_diff(array_keys($types), $this->allowedNotifications);
        if (!empty($not_allowed_notifications)) {
            $notifications = [];
            foreach ($not_allowed_notifications as $type) {
                $notifications[] = [$type => false];
            }
            $this->user->notifications = $notifications;
            $this->user->save();
        }
        else {
            $this->user->notifications = NULL;
            $this->user->save();
        }
    }
}
