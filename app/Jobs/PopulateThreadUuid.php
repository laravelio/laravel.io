<?php

namespace App\Jobs;

use App\Models\Thread;
use Ramsey\Uuid\Uuid;

class PopulateThreadUuid
{
    public function __construct(private Thread $thread)
    {
    }

    public function handle(): void
    {
        $this->thread->uuid = Uuid::uuid4()->toString();
        $this->thread->save();
    }
}
