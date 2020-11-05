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
        $article = Article::factory()->create(['author_id' => $user->id()]);

        $article = $this->dispatch(new UpdateArticle($article, 'Title', 'Body', false));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
    }

    /** @test */
    public function we_can_submit_an_existing_article_for_approval()
    {
        $user = $this->createUser();
        $article = Article::factory()->create(['author_id' => $user->id()]);

        $article = $this->dispatch(new UpdateArticle($article, 'Title', 'Body', true));

        $this->assertNotNull($article->submittedAt());
    }

    /** @test */
    public function we_cannot_update_sumbitted_at_when_saving_changes()
    {
        $user = $this->createUser();
        $article = Article::factory()->create(['author_id' => $user->id(), 'submitted_at' => '2020-06-20 00:00:00']);

        $article = $this->dispatch(new UpdateArticle($article, 'Title', 'Body', false));

        $this->assertSame('2020-06-20 00:00:00', $article->submittedAt()->format('Y-m-d H:i:s'));
        $this->assertTrue($article->isNotPublished());
    }

    /** @test */
    public function we_can_update_an_article_with_a_series()
    {
        $user = $this->createUser();
        $article = Article::factory()->create(['author_id' => $user->id()]);
        $series = Series::factory()->create(['author_id' => $user->id()]);

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
        $series = Series::factory()->create();
        $article = Article::factory()->create(['author_id' => $user->id(), 'series_id' => $series->id]);

        $article = $this->dispatch(new UpdateArticle($article, 'Title', 'Body', true));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
        $this->assertEquals(null, $article->series);
    }
}
