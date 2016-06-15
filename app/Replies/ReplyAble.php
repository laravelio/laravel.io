<?php

namespace Lio\Replies;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ReplyAble
{
    public function replyAble(): MorphMany;
}
