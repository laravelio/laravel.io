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
        return $this->replyAble;
    }

    public function replyAble(): MorphMany
    {
        return $this->morphMany(Reply::class, 'replyable');
    }
}
