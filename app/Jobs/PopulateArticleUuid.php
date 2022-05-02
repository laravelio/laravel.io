<?php

namespace App\Jobs;

use App\Models\Article;
use Ramsey\Uuid\Uuid;

class PopulateArticleUuid
{
    public function __construct(private Article $article)
    {
    }

    public function handle(): void
    {
        $this->article->uuid = Uuid::uuid4()->toString();
        $this->article->save();
    }
}
