<?php

namespace App\Listeners;

use App\Events\ReplyWasCreated;
use App\Notifications\NewReply;

class SendNewReplyNotification
{
    public function handle(ReplyWasCreated $event)
    {
        foreach ($event->reply->replyAble()->subscriptions() as $subscription) {
            $subscription->user()->notify(new NewReply());
        }
    }
}
