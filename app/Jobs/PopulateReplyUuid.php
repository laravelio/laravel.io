<?php

namespace App\Jobs;

use App\Models\Reply;
use Ramsey\Uuid\Uuid;

class PopulateReplyUuid
{
    public function __construct(private Reply $reply)
    {
    }

    public function handle(): void
    {
        $this->reply->uuid = Uuid::uuid4()->toString();
        $this->reply->save();
    }
}
