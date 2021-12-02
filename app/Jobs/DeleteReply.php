<?php

namespace App\Jobs;

use App\Models\Reply;

final class DeleteReply
{
    public function __construct(
        private Reply $reply
    ) {
    }

    public function handle()
    {
        $this->reply->delete();
    }
}
