<?php
namespace Lio\Replies;

trait HasManyReplies
{
    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies()
    {
        return $this->replyable;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replyable()
    {
        return $this->hasMany(EloquentReply::class);
    }
}
