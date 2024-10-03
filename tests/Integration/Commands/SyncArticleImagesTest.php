<?php

use App\Console\Commands\SyncArticleImages;
use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);


test('hero image url and author information is updated for published articles with hero image', function () {
    Http::fake(function () {
        return [
            'urls' => [
                'raw' => 'https://images.unsplash.com/photo-1584824486509-112e4181ff6b?ixid=M3w2NTgwOTl8MHwxfGFsbHx8fHx8fHx8fDE3Mjc2ODMzMzZ8&ixlib=rb-4.0.3'
            ],
            'user' => [
                'name' => 'Erik Mclean',
                'links' => [
                    'html' => 'https://unsplash.com/@introspectivedsgn',
                ]
            ],
        ];
    });

    $article = Article::factory()->create([
        'hero_image' => 'sxiSod0tyYQ',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new SyncArticleImages)->handle();

    $article->refresh();

    expect($article->heroImage())->toContain('https://images.unsplash.com/photo-1584824486509-112e4181ff6b');
    expect($article->hero_image_author_name)->toBe('Erik Mclean');
    expect($article->hero_image_author_url)->toBe('https://unsplash.com/@introspectivedsgn');
});

test('hero image url and author information is not updated for published articles with no hero image', function () {
    $article = Article::factory()->create([
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new SyncArticleImages)->handle();

    $article->refresh();

    expect($article->hero_image_url)->toBe(null);
    expect($article->hero_image_author_name)->toBe(null);
    expect($article->hero_image_author_url)->toBe(null);
});
