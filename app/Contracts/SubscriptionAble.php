<?php

namespace App\Contracts;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface SubscriptionAble
{
    /**
     * @return Subscription[]
     */
    public function subscriptions();

    public function subscriptionsRelation(): MorphMany;

    public function hasSubscriber(User $user): bool;
}
