<?php

namespace App\Replies;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ReplyAble
{
    public function replySubject(): string;
    public function replyExcerpt(): string;

    /**
     * @return \App\Replies\Reply[]
     */
    public function replies();

    /**
     * @return \App\Replies\Reply[]
     */
    public function latestReplies(int $amount = 5);
    public function repliesRelation(): MorphMany;
}
