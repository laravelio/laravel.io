<?php

namespace Tests\Integration\Jobs;

use App\Jobs\UnlikeArticle;
use App\Models\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnlikeArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_unlike_an_article()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create();

        $article->likedBy($user);
        $this->assertTrue($article->fresh()->isLikedBy($user));

        $this->dispatch(new UnlikeArticle($article, $user));

        $this->assertFalse($article->fresh()->isLikedBy($user));
    }
}
