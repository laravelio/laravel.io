<?php

namespace Lio\Replies;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyReplies
{
    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies()
    {
        return $this->replyable;
    }

    public function replyable(): HasMany
    {
        return $this->hasMany(EloquentReply::class);
    }
}
