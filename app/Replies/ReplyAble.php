<?php

namespace App\Replies;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ReplyAble
{
    /**
     * @return \App\Replies\Reply[]
     */
    public function replies();
    public function repliesRelation(): MorphMany;
}
