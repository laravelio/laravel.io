<?php

namespace App\Helpers;

use App\User;
use App\Models\Like;

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

    public function likes()
    {
        return $this->morphMany(Like::class, 'liked');
    }

    public function isLikedBy(User $user)
    {
        if ($user == null) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }
}
