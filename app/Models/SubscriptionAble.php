<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface SubscriptionAble
{
    /**
     * @return \App\Models\Subscription[]
     */
    public function subscriptions();

    public function subscriptionsRelation(): MorphMany;

    public function hasSubscriber(User $user): bool;
}
