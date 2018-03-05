<?php

namespace App\Models;

use App\User;
use App\Helpers\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Subscription extends Model
{
    use HasUuid;

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

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/portal/issues/350
     */
    public function subscriptionAbleRelation(): MorphTo
    {
        return $this->morphTo('subscriptionAbleRelation', 'subscriptionable_type', 'subscriptionable_id');
    }
}
