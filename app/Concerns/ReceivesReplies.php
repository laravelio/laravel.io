<?php

namespace App\Concerns;

use App\Models\Reply;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ReceivesReplies
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function replies()
    {
        return $this->repliesRelation;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latestReplies(int $amount = 5)
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

    public function isConversationOld(): bool
    {
        $sixMonthsAgo = now()->subMonths(6);

        if ($reply = $this->repliesRelation()->latest()->first()) {
            return $reply->createdAt()->lt($sixMonthsAgo);
        }

        return $this->createdAt()->lt($sixMonthsAgo);
    }
}
