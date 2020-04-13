<?php

namespace Tests\Integration\Jobs;

use App\Jobs\UpdateArticle;
use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateArticleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_an_article()
    {
        $user = $this->createUser();
        $article = factory(Article::class)->create(['author_id' => $user->id()]);

        $article = $this->dispatch(new UpdateArticle($article, ['title' => 'Title', 'body' => 'Body']));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
    }
}
