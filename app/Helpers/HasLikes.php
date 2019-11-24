<?php

namespace App\Helpers;

use App\User;
use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    protected static function bootHasLikes()
    {
        static::deleting(function ($model) {
            $model->likes->each->delete();
        });
    }

    public function likedBy(User $user)
    {
        $this->likes()->create(['user_id' => $user->id]);
    }

    public function dislikedBy(User $user)
    {
        optional($this->likes()->where('user_id', $user->id)->get()->first())->delete();
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLikedBy(User $user): bool
    {
        if ($user == null) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function getLikesCountAttribute(): int
    {
        return $this->likes->count();
    }
}
