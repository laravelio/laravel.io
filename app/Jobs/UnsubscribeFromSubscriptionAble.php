<?php

namespace App\Jobs;

use App\Models\SubscriptionAble;
use App\Models\User;

final class UnsubscribeFromSubscriptionAble
{
    public function __construct(
        private User $user,
        private SubscriptionAble $subscriptionAble
    ) {
    }

    public function handle()
    {
        $this->subscriptionAble->subscriptionsRelation()
            ->where('user_id', $this->user->id())
            ->delete();
    }
}
