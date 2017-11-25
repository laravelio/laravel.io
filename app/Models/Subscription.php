<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'subscriptions';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'subscriptionable_id',
        'subscriptionable_type',
    ];

    public function user(): User
    {
        return $this->userRelation;
    }

    public function userRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
