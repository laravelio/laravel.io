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
            if (! $user->hasBlocked($event->reply->author())) {
                $user->notify(new MentionNotification($event->reply));
            }
        });
    }
}
