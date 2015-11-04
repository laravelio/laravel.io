<?php
namespace Lio\Replies;

interface ReplyAble
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
     */
    public function replyable();
}
