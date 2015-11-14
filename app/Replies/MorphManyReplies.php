<?php
namespace Lio\Replies;

trait MorphManyReplies
{
    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies()
    {
        return $this->replyAble;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function replyAble()
    {
        return $this->morphMany(EloquentReply::class, 'replyable');
    }
}
