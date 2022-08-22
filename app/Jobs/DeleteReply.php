<?php

namespace App\Jobs;

use App\Models\Reply;

final class DeleteReply
{
    public function __construct(private Reply $reply)
    {
    }

    public function handle(): void
    {
        if (!$this->reply->isAuthoredBy(auth()->user())) {
            $this->reply->update([
                'deleted_at' => now(),
                'deleted_by' => auth()->id(),
            ]);
        } else {
            $this->reply->forceDelete();
        }
    }
}
