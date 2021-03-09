<?php

namespace App\Helpers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function likes()
    {
        return $this->likesRelation;
    }

    protected static function bootHasLikes()
    {
        static::deleting(function ($model) {
            $model->likesRelation()->delete();
        });
    }

    public function likedBy(User $user)
    {
        $this->likesRelation()->create(['user_id' => $user->id()]);
    }

    public function dislikedBy(User $user)
    {
        optional($this->likes()->where('user_id', $user->id())->first())->delete();
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function likesRelation(): MorphMany
    {
        return $this->morphMany(Like::class, 'likesRelation', 'likeable_type', 'likeable_id');
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id())->isNotEmpty();
    }
}
