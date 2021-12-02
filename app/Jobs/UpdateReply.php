<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\User;

final class UpdateReply
{
    public function __construct(
        private Reply $reply,
        private User $updatedBy,
        private string $body
    ) {
    }

    public function handle()
    {
        $this->reply->body = $this->body;
        $this->reply->updatedByRelation()->associate($this->updatedBy);
        $this->reply->save();
    }
}
