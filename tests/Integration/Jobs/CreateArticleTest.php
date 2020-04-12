<?php

namespace Tests\Integration\Jobs;

use App\Jobs\CreateArticle;
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
}
