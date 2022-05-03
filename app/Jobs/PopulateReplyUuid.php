<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PopulateReplyUuid implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

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
