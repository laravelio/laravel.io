<?php

namespace Tests\Integration\Jobs;

use App\Jobs\CreateArticle;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_draft_article()
    {
        $user = $this->createUser();

        $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, false, [
            'original_url' => 'https://laravel.io',
        ]));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
        $this->assertEquals('https://laravel.io', $article->canonicalUrl());
        $this->assertNull($article->submittedAt());
        $this->assertTrue($article->isNotPublished());
    }

    /** @test */
    public function we_can_create_an_article_and_submit_it_for_approval()
    {
        $user = $this->createUser();

        $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, true, [
            'original_url' => 'https://laravel.io',
        ]));

        $this->assertNotNull($article->submittedAt());
    }
}
