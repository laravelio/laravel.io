<?php

namespace App\Jobs;

use App\Models\Subscription;
use App\Models\SubscriptionAble;
use App\User;
use Ramsey\Uuid\Uuid;

final class SubscribeToSubscriptionAble
{
    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var \App\Models\SubscriptionAble
     */
    private $subscriptionAble;

    public function __construct(User $user, SubscriptionAble $subscriptionAble)
    {
        $this->user = $user;
        $this->subscriptionAble = $subscriptionAble;
    }

    public function handle()
    {
        $subscription = new Subscription();
        $subscription->uuid = Uuid::uuid4()->toString();
        $subscription->userRelation()->associate($this->user);
        $this->subscriptionAble->subscriptionsRelation()->save($subscription);
    }
}
