<?php

namespace App\Helpers;

use App\Models\Like;
use App\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    protected static function bootHasLikes()
    {
        static::deleting(function ($model) {
            $model->likes()->delete();
        });
    }

    public function likedBy(User $user)
    {
        $this->likes()->create(['user_id' => $user->id()]);
    }

    public function dislikedBy(User $user)
    {
        optional($this->likes()->where('user_id', $user->id())->first())->delete();
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id())->exists();
    }

    public function likesCount(): int
    {
        return $this->likes()->count();
    }
}
