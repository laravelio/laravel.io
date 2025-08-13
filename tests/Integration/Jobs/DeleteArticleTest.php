<?php

use App\Jobs\DeleteArticle;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('an article can be deleted', function () {
    $article = Article::factory()->create();

    $this->dispatch(new DeleteArticle($article));

    $this->assertDatabaseMissing('articles', ['id' => $article->id()]);
});
