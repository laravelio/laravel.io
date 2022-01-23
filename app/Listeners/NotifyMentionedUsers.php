<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ThreadWasCreated;
use App\Notifications\MentionNotification;

final class NotifyMentionedUsers
{
    public function handle(ThreadWasCreated $event): void
    {
        $event->thread->getMentionedUsers()->each(function ($user) use ($event) {
            $user->notify(new MentionNotification($event->thread));
        });
    }
}
