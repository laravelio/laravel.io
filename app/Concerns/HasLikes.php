<?php

namespace App\Concerns;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasLikes
{
    protected static function bootHasLikes(): void
    {
        static::deleting(function ($model) {
            $model->likesRelation()->delete();

            $model->unsetRelation('likesRelation');
        });
    }

    public function likes(): Collection
    {
        return $this->likesRelation;
    }

    public function likers(): Collection
    {
        return $this->likersRelation;
    }

    public function likedBy(User $user): void
    {
        $this->likesRelation()->create(['user_id' => $user->id()]);

        $this->unsetRelation('likesRelation');
    }

    public function dislikedBy(User $user): void
    {
        optional($this->likesRelation()->where('user_id', $user->id())->first())->delete();

        $this->unsetRelation('likesRelation');
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likesRelation()->where('user_id', $user->id())->exists();
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

    public function likersRelation(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Like::class, 'likeable_id')
            ->where('likeable_type', array_search(static::class, Relation::morphMap()) ?: static::class);
    }
}
