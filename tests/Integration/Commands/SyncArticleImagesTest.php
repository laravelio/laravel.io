<?php

use App\Console\Commands\SyncArticleImages;
use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);


test('hero image url is updated for published articles with hero image', function () {

    $article = Article::factory()->create([
        'hero_image' => 'sxiSod0tyYQ',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new SyncArticleImages)->handle();

    $article->refresh();

    expect($article->heroImage())->toBeUrl();
    expect($article->heroImage())->toContain('https://images.unsplash.com/photo-1584824486509-112e4181ff6b');
});

test('hero image url is not updated for published articles with no hero image', function () {

    $article = Article::factory()->create([
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new SyncArticleImages)->handle();

    $article->refresh();

    expect($article->hero_image_url)->toBe(null);
});
