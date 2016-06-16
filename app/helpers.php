<?php

use Lio\Replies\ReplyAble;

if (! function_exists('route_to_reply_able')) {
    /**
     * Returns the route for the replyAble.
     */
    function route_to_reply_able(ReplyAble $replyAble): string
    {
        if ($replyAble instanceof \Lio\Forum\Thread) {
            return route('thread', $replyAble->slug());
        }
    }
}
