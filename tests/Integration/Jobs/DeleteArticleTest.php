<?php

namespace Tests\Integration\Jobs;

use App\Jobs\DeleteArticle;
use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteArticleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_article_can_be_deleted()
    {
        $article = factory(Article::class)->create();

        $this->dispatch(new DeleteArticle($article));

        $this->assertDatabaseMissing('articles', ['id' => $article->id()]);
    }
}
