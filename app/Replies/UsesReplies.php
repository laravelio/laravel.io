<?php

namespace App\Replies;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait UsesReplies
{
    /**
     * @return \App\Replies\Reply[]
     */
    public function replies()
    {
        return $this->repliesRelation;
    }

    /**
     * @return \App\Replies\Reply[]
     */
    public function latestReplies(int $amount = 5)
    {
        return $this->repliesRelation()->orderBy('created_at', 'DESC')->limit($amount)->get();
    }

    public function repliesRelation(): MorphMany
    {
        return $this->morphMany(Reply::class, 'replyable');
    }
}
