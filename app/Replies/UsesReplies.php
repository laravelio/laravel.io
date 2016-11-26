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

    public function repliesRelation(): MorphMany
    {
        return $this->morphMany(Reply::class, 'replyable');
    }
}
