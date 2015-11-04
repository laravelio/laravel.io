<?php
namespace Lio\Replies;

trait MorphManyReplies
{
    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies()
    {
        return $this->replyable;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function replyable()
    {
        return $this->morphMany(EloquentReply::class, 'replyable');
    }
}
