<?php

namespace App\Jobs;

use App\Enums\NotificationTypes;
use App\Models\User;

final class SaveNotificationSettings
{
    public function __construct(private User $user, private readonly array $allowedNotifications)
    {
    }

    public function handle(): void
    {
        $types = NotificationTypes::getTypes();

        $not_allowed_notifications = array_diff(array_keys($types), $this->allowedNotifications);

        $notifications = null;
        if (!empty($not_allowed_notifications)) {
            $notifications = [];
            foreach ($not_allowed_notifications as $type) {
                $notifications[] = [$type => false];
            }
        }

        $this->user->notifications = $notifications;
        $this->user->save();
    }
}
