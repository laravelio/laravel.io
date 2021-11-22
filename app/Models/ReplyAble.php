<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * This interface allows models to receive replies.
 */
interface ReplyAble
{
    public function subject(): string;

    public function lastActiveAt(): ?Carbon;

    public function touchActivity();

    /**
     * @return \App\Models\Reply[]
     */
    public function replies();

    /**
     * @return \App\Models\Reply[]
     */
    public function latestReplies(int $amount = 5);

    public function deleteReplies();

    public function repliesRelation(): MorphMany;

    public function isConversationOld(): bool;

    public function replyAbleSubject(): string;
}
