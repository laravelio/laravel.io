<?php

namespace App\Concerns;

use App\Models\ReplyAble;

trait HasMentions
{
    public function mentionedOn(): ReplyAble
    {
        if ($this instanceof ReplyAble) {
            return $this;
        }

        return $this->replyAble();
    }
}
