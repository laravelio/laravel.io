<?php

namespace App\Jobs;

use App\User;
use App\Models\SubscriptionAble;

class UnsubscribeFromSubscriptionAble
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
