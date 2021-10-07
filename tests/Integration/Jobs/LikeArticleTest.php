<?php

use App\Exceptions\CannotLikeItem;
use App\Jobs\LikeArticle;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can like an article', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();

    $this->dispatch(new LikeArticle($article, $user));

    expect($article->fresh()->isLikedBy($user))->toBeTrue();
});

test('we cannot like an article twice', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();

    $this->dispatch(new LikeArticle($article, $user));

    expect($article->fresh()->isLikedBy($user))->toBeTrue();

    $this->expectException(CannotLikeItem::class);

    $this->dispatch(new LikeArticle($article, $user));
});
