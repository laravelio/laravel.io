<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PopulateArticleUuid implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    public function __construct(private int $article_id)
    {
    }

    public function handle(): void
    {
        DB::table('articles')
            ->where('id', $this->article_id)
            ->update(['uuid' => Uuid::uuid4()->toString()]);
    }
}
