<?php

namespace App\Contracts;

use App\Models\Reply;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * This interface allows models to receive replies.
 */
interface ReplyAble
{
    public function subject(): string;

    /**
     * @return Reply[]
     */
    public function replies();

    /**
     * @return Reply[]
     */
    public function latestReplies(int $amount = 5);

    public function deleteReplies();

    public function repliesRelation(): MorphMany;

    public function isConversationOld(): bool;

    public function replyAbleSubject(): string;
}
