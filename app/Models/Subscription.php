<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Subscription extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'subscriptions';

    public function user(): User
    {
        return $this->userRelation;
    }

    public function userRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscriptionAble(): SubscriptionAble
    {
        return $this->subscriptionAbleRelation;
    }

    public function subscriptionAbleRelation(): MorphTo
    {
        return $this->morphTo('subscriptionable');
    }
}
