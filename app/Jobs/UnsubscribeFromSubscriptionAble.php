<?php

namespace App\Jobs;

use App\Models\SubscriptionAble;
use App\User;

final class UnsubscribeFromSubscriptionAble
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
        $this->subscriptionAble->subscriptionsRelation()
            ->where('user_id', $this->user->id())
            ->delete();
    }
}
