<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReplyWasCreated;
use App\Models\Thread;

final class SubscribeUsersMentionedInReply
{
    public function handle(ReplyWasCreated $event): void
    {
        $event->reply->getMentionedUsers()->each(function ($user) use ($event) {
            $replyAble = $event->reply->mentionedIn();

            if (! $replyAble instanceof Thread) {
                return;
            }

            if($replyAble->hasSubscriber($user)) {
                return;
            }

            $replyAble->subscribe($user);
        });
    }
}
