<?php

namespace App\Concerns;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Ramsey\Uuid\Uuid;

trait ProvidesSubscriptions
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function subscriptions()
    {
        return $this->subscriptionsRelation;
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function subscriptionsRelation(): MorphMany
    {
        return $this->morphMany(
            Subscription::class,
            'subscriptionsRelation',
            'subscriptionable_type',
            'subscriptionable_id',
        );
    }

    public function hasSubscriber(User $user): bool
    {
        return $this->subscriptionsRelation()
            ->where('user_id', $user->id())
            ->exists();
    }

    public function subscribe(User $user): Subscription
    {
        $subscription = new Subscription();
        $subscription->uuid = Uuid::uuid4()->toString();
        $subscription->userRelation()->associate($user);
        $subscription->subscriptionAbleRelation()->associate($this);

        return $this->subscriptionsRelation()->save($subscription);
    }
}
