<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ThreadWasCreated;
use App\Models\Subscription;
use Ramsey\Uuid\Uuid;

final class SubscribeMentionedUsersToThread
{
    public function handle(ThreadWasCreated $event): void
    {
        $event->thread->getMentionedUsers()->each(function ($user) use ($event) {
            if($event->thread->hasSubscriber($user)) {
                return;
            }

            $subscription = new Subscription();
            $subscription->uuid = Uuid::uuid4()->toString();
            $subscription->userRelation()->associate($user);
            $subscription->subscriptionAbleRelation()->associate($event->thread);

            $event->thread->subscriptionsRelation()->save($subscription);
        });
    }
}
