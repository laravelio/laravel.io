<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReplyWasCreated;
use App\Notifications\MentionNotification;

final class NotifyUsersMentionedInReply
{
    public function handle(ReplyWasCreated $event): void
    {
        $event->reply->mentionedUsers()->each(function ($user) use ($event) {
            if (! $user->isNotificationAllowed(MentionNotification::class)) {
                return;
            }

            if ($user->hasBlocked($event->reply->author())) {
                return;
            }

            if ($event->reply->replyAble()->participants()->contains($user)) {
                return;
            }

            $user->notify(new MentionNotification($event->reply));
        });
    }
}
