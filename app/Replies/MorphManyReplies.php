<?php

namespace Lio\Replies;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait MorphManyReplies
{
    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies()
    {
        return $this->replyAble;
    }

    public function replyAble(): MorphMany
    {
        return $this->morphMany(EloquentReply::class, 'replyable');
    }
}
