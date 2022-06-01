<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReplyWasCreated;
use App\Models\Thread;

final class SubscribeUsersMentionedInReply
{
    public function handle(ReplyWasCreated $event): void
    {
        $event->reply->mentionedUsers()->each(function ($user) use ($event) {
            $replyAble = $event->reply->mentionedIn();

            if ($replyAble instanceof Thread && ! $replyAble->hasSubscriber($user)) {
                $replyAble->subscribe($user);
            }
        });
    }
}
