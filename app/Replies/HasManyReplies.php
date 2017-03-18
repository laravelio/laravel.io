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
        return $this->replyAble;
    }

    /**
     * @return \App\Replies\Reply[]
     */
    public function latestReplies(int $amount = 3)
    {
        return $this->replyAble()->orderBy('created_at', 'DESC')->limit($amount)->get();
    }

    public function replyAble(): HasMany
    {
        return $this->hasMany(Reply::class, 'author_id');
    }
}
