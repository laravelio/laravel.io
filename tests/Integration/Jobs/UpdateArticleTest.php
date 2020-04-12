<?php

namespace Tests\Integration\Jobs;

use App\Jobs\UpdateArticle;
use App\Models\Article;
use App\Models\Series;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateArticleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_update_an_article()
    {
        $user = $this->createUser();
        $article = factory(Article::class)->create(['author_id' => $user->id()]);

        $article = $this->dispatch(new UpdateArticle($article, 'Title', 'Body', false));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
    }

    /** @test */
    public function we_can_publish_an_existing_article()
    {
        $user = $this->createUser();
        $article = factory(Article::class)->create(['author_id' => $user->id()]);

        $article = $this->dispatch(new UpdateArticle($article, 'Title', 'Body', true));

        $this->assertNotNull($article->publishedAt());
        $this->assertTrue($article->isPublished());
    }

    /** @test */
    public function we_can_unpublish_an_existing_article()
    {
        $user = $this->createUser();
        $article = factory(Article::class)->create(['author_id' => $user->id(), 'published_at' => now()]);

        $article = $this->dispatch(new UpdateArticle($article, 'Title', 'Body', false));

        $this->assertNull($article->publishedAt());
        $this->assertTrue($article->isNotPublished());
    }

    /** @test */
    public function we_can_update_an_article_with_a_series()
    {
        $user = $this->createUser();
        $article = factory(Article::class)->create(['author_id' => $user->id()]);
        $series = factory(Series::class)->create(['author_id' => $user->id()]);

        $article = $this->dispatch(new UpdateArticle($article, 'Title', 'Body', true, [
            'original_url' => 'https://laravel.io',
            'series' => $series->id,
        ]));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
        $this->assertEquals('https://laravel.io', $article->canonicalUrl());
        $this->assertEquals($series->id, $article->id());
    }

    /** @test */
    public function we_can_remove_an_article_from_a_series()
    {
        $user = $this->createUser();
        $series = factory(Series::class)->create();
        $article = factory(Article::class)->create(['author_id' => $user->id(), 'series_id' => $series->id]);

        $article = $this->dispatch(new UpdateArticle($article, 'Title', 'Body', true));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
        $this->assertEquals(null, $article->series);
    }
}
