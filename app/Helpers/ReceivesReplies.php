<?php

namespace App\Helpers;

use App\Models\Reply;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ReceivesReplies
{
    /**
     * @return \App\Models\Reply[]
     */
    public function replies()
    {
        return $this->repliesRelation;
    }

    /**
     * @return \App\Models\Reply[]
     */
    public function latestReplies(int $amount = 5)
    {
        return $this->repliesRelation()->latest()->limit($amount)->get();
    }

    public function deleteReplies()
    {
        $this->repliesRelation()->delete();
    }

    public function repliesRelation(): MorphMany
    {
        return $this->morphMany(Reply::class, 'replyable');
    }
}
