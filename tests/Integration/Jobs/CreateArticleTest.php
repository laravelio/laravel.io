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

        $article = $this->dispatch(new CreateArticle('Title', 'Body', $user));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
    }

    /** @test */
    public function we_can_create_an_article_with_a_series()
    {
        $user = $this->createUser();
        $series = factory(Series::class)->create(['author_id' => $user->id()]);

        $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, [], $series->id));

        $this->assertEquals('Title', $article->title());
        $this->assertEquals('Body', $article->body());
        $this->assertEquals($series->id, $article->id());
    }
}
