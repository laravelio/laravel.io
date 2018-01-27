<?php

namespace App\Helpers;

use App\User;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ProvidesSubscriptions
{
    /**
     * @return \App\Models\Subscription[]
     */
    public function subscriptions()
    {
        return $this->subscriptionsRelation;
    }

    public function subscriptionsRelation(): MorphMany
    {
        return $this->morphMany(Subscription::class, 'subscriptionable');
    }

    public function hasSubscriber(User $user): bool
    {
        return $this->subscriptionsRelation()
            ->where('user_id', $user->id())
            ->exists();
    }
}
