<?php

namespace App\Concerns;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait ReceivesReplies
{
    public function replies(): Collection
    {
        return $this->repliesRelation;
    }

    public function repliesWithTrashed(): Collection
    {
        return $this->repliesRelationWithTrashed;
    }

    public function replyAuthors(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            Reply::class,
            'replyable_id',
            'id',
            'id',
            'author_id',
        )->where(
            'replyable_type',
            array_search(static::class, Relation::morphMap()),
        );
    }

    public function latestReplies(int $amount = 5): Collection
    {
        return $this->repliesRelation()->latest()->limit($amount)->get();
    }

    public function deleteReplies()
    {
        // We need to explicitly iterate over the replies and delete them
        // separately because all related models need to be deleted.
        foreach ($this->repliesRelation()->get() as $reply) {
            $reply->delete();
        }

        $this->unsetRelation('repliesRelation');
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function repliesRelation(): MorphMany
    {
        return $this->morphMany(Reply::class, 'repliesRelation', 'replyable_type', 'replyable_id');
    }

    public function repliesRelationWithTrashed(): MorphMany
    {
        return $this->morphMany(Reply::class, 'repliesRelation', 'replyable_type', 'replyable_id')->withTrashed();
    }

    public function isConversationOld(): bool
    {
        $sixMonthsAgo = now()->subMonths(6);

        if ($reply = $this->repliesRelation()->latest()->first()) {
            return $reply->createdAt()->lt($sixMonthsAgo);
        }

        return $this->createdAt()->lt($sixMonthsAgo);
    }

    public static function bootReceivesReplies(): void
    {
        static::deleting(function ($replyable) {
            $replyable->repliesRelation()->forceDelete();
        });
    }
}
