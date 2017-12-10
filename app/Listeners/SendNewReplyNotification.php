<?php

namespace App\Listeners;

use App\Events\ReplyWasCreated;
use App\Notifications\NewReplyNotification;
use App\User;

class SendNewReplyNotification
{
    public function handle(ReplyWasCreated $event): void
    {
        foreach ($event->reply->replyAble()->subscriptions() as $subscription) {
            if ($this->replyAuthorDoesNotMatchSubscriber($event->reply->author(), $subscription)) {
                $subscription->user()->notify(new NewReplyNotification($event->reply));
            }
        }
    }

    private function replyAuthorDoesNotMatchSubscriber(User $author, $subscription): bool
    {
        return ! $author->matches($subscription->user());
    }
}
