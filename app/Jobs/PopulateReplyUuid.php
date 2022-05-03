<?php

namespace App\Jobs;

use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PopulateReplyUuid
{
    public function __construct(private int $reply_id)
    {
    }

    public function handle(): void
    {
        DB::table('replies')
            ->where('id', $this->reply_id)
            ->update(['uuid' => Uuid::uuid4()->toString()]);
    }
}
