<?php

use App\Jobs\UnlikeArticle;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can unlike an article', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();

    $article->likedBy($user);
    $this->assertTrue($article->fresh()->isLikedBy($user));

    $this->dispatch(new UnlikeArticle($article, $user));

    $this->assertFalse($article->fresh()->isLikedBy($user));
});
