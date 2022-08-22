<?php

namespace App\Jobs;

use App\Contracts\SubscriptionAble;
use App\Models\User;

final class UnsubscribeFromSubscriptionAble
{
    public function __construct(private User $user, private SubscriptionAble $subscriptionAble)
    {
    }

    public function handle(): void
    {
        $this->subscriptionAble->subscriptionsRelation()
            ->where('user_id', $this->user->id())
            ->delete();
    }
}
