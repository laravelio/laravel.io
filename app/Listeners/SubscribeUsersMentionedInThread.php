<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ThreadWasCreated;

final class SubscribeUsersMentionedInThread
{
    public function handle(ThreadWasCreated $event): void
    {
        $event->thread->getMentionedUsers()->each(function ($user) use ($event) {
            if (! $event->thread->hasSubscriber($user)) {
                $event->thread->subscribe($user);
            }
        });
    }
}
