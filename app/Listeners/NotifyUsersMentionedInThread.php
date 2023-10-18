<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ThreadWasCreated;
use App\Notifications\MentionNotification;

final class NotifyUsersMentionedInThread
{
    public function handle(ThreadWasCreated $event): void
    {
        $event->thread->mentionedUsers()->each(function ($user) use ($event) {
            if (! $user->isNotificationAllowed(MentionNotification::class)) {
                return;
            }

            if ($user->hasBlocked($event->thread->author())) {
                return;
            }

            $user->notify(new MentionNotification($event->thread));
        });
    }
}
