<?php

namespace App\Replies;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyReplies
{
    /**
     * @return \App\Replies\Reply[]
     */
    public function replies()
    {
        return $this->replyable;
    }

    public function replyAble(): HasMany
    {
        return $this->hasMany(Reply::class);
    }
}
