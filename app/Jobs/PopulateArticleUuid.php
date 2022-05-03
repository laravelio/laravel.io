<?php

namespace App\Jobs;

use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PopulateArticleUuid
{
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
