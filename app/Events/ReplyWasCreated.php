<?php

namespace App\Events;

use App\Models\Reply;
use Illuminate\Queue\SerializesModels;

final class ReplyWasCreated
{
    use SerializesModels;

    public function __construct(
        public Reply $reply
    ) {
    }
}
