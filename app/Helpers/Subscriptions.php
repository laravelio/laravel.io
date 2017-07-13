<?php

namespace App\Helpers;

use App\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Subscriptions
{
    public function subscribers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'subscriptionable', 'subscriptions')->withTimeStamps();
    }

    public function subscribersWhereNot(User $user): MorphToMany
    {
        return $this->subscribers()->where('user_id', '!=', $user->id);
    }

    public function isSubscriber(User $user): bool
    {
        return (bool) $this->subscribers()->where('user_id', $user->id)->count();
    }
}
