<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ReplyAble
{
    /**
     * @return \App\Models\Reply[]
     */
    public function replies();

    /**
     * @return \App\Models\Reply[]
     */
    public function latestReplies(int $amount = 5);

    public function removeReplies();

    public function repliesRelation(): MorphMany;
}
