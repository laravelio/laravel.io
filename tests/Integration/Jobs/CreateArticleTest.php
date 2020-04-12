<?php

namespace Tests\Integration\Jobs;

use App\Jobs\CreateArticle;
use App\Models\Series;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_an_article()
    {
        $user = $this->createUser();

        $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, false, ['original_url' => 'https://laravel.io']));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
        $this->assertEquals('https://laravel.io', $article->canonicalUrl());
    }

    /** @test */
    public function we_can_create_an_article_and_submit_it_for_approval()
    {
        $user = $this->createUser();

        $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, true, ['original_url' => 'https://laravel.io']));

        $this->assertNotNull($article->submittedAt());
    }

    /** @test */
    public function we_can_create_a_draft_article()
    {
        $user = $this->createUser();

        $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, false, ['original_url' => 'https://laravel.io']));

        $this->assertNull($article->submittedAt());
        $this->assertTrue($article->isNotPublished());
    }

    /** @test */
    public function we_can_create_an_article_with_a_series()
    {
        $user = $this->createUser();
        $series = factory(Series::class)->create(['author_id' => $user->id()]);

        $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, false, [
            'original_url' => 'https://laravel.io',
            'series_id' => $series->id,
        ]));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
        $this->assertEquals('https://laravel.io', $article->canonicalUrl());
        $this->assertEquals($series->id, $article->id());
    }
}
