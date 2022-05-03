<?php

namespace App\Jobs;

use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PopulateThreadUuid
{
    public function __construct(private int $thread_id)
    {
    }

    public function handle(): void
    {
        DB::table('threads')
            ->where('id', $this->thread_id)
            ->update(['uuid' => Uuid::uuid4()->toString()]);
    }
}
