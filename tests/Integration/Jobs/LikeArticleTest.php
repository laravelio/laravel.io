<?php

namespace Tests\Integration\Jobs;

use App\Exceptions\CannotLikeItem;
use App\Jobs\LikeArticle;
use App\Models\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_like_an_article()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $this->dispatch(new LikeArticle($article, $user));

        $this->assertTrue($article->fresh()->isLikedBy($user));
    }

    /** @test */
    public function we_cannot_like_an_article_twice()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $this->dispatch(new LikeArticle($article, $user));

        $this->assertTrue($article->fresh()->isLikedBy($user));

        $this->expectException(CannotLikeItem::class);

        $this->dispatch(new LikeArticle($article, $user));
    }
}
