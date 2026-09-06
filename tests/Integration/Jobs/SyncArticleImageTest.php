<?php

use App\Jobs\SyncArticleImage;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('hero image url and author information is updated for published articles with hero image', function () {
    Config::set('services.unsplash.access_key', 'test');

    Http::fake(function () {
        return [
            'links' => [
                'download_location' => 'https://example.com',
            ],
            'urls' => [
                'raw' => 'https://images.unsplash.com/photo-1584824486509-112e4181ff6b?ixid=M3w2NTgwOTl8MHwxfGFsbHx8fHx8fHx8fDE3Mjc2ODMzMzZ8&ixlib=rb-4.0.3',
            ],
            'user' => [
                'name' => 'Erik Mclean',
                'links' => [
                    'html' => 'https://unsplash.com/@introspectivedsgn',
                ],
            ],
        ];
    });

    $article = Article::factory()->create([
        'hero_image_id' => 'sxiSod0tyYQ',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    SyncArticleImage::dispatchSync($article);

    $article->refresh();

    expect($article->heroImage())->toContain('https://images.unsplash.com/photo-1584824486509-112e4181ff6b');
    expect($article->hero_image_author_name)->toBe('Erik Mclean');
    expect($article->hero_image_author_url)->toBe('https://unsplash.com/@introspectivedsgn');
});

test('hero image url and author information is not updated for published articles with no hero image', function () {
    Config::set('services.unsplash.access_key', 'test');
    Http::fake();

    $article = Article::factory()->create([
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    SyncArticleImage::dispatchSync($article);

    $article->refresh();

    expect($article->hero_image_url)->toBe(null);
    expect($article->hero_image_author_name)->toBe(null);
    expect($article->hero_image_author_url)->toBe(null);

    Http::assertNothingSent();
});

test('hero image data is preserved when Unsplash returns an invalid photo response', function ($response) {
    Config::set('services.unsplash.access_key', 'test');

    Http::fake([
        'api.unsplash.com/photos/*' => Http::response($response),
    ]);

    $article = Article::factory()->create([
        'hero_image_id' => 'invalid-photo-id',
        'hero_image_url' => 'https://images.unsplash.com/existing-photo',
        'hero_image_author_name' => 'Existing author',
        'hero_image_author_url' => 'https://unsplash.com/@existing-author',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    SyncArticleImage::dispatchSync($article);

    expect($article->refresh()->hero_image_id)->toBe('invalid-photo-id');
    expect($article->hero_image_url)->toBe('https://images.unsplash.com/existing-photo');
    expect($article->hero_image_author_name)->toBe('Existing author');
    expect($article->hero_image_author_url)->toBe('https://unsplash.com/@existing-author');

    Http::assertSentCount(1);
})->with([
    'missing links' => [['errors' => ['Unable to find the requested photo.']]],
    'photo list' => [[['id' => 'some-photo']]],
    'non-JSON response' => ['Service unavailable'],
    'empty download location' => [[
        'links' => ['download_location' => ''],
        'urls' => ['raw' => 'https://images.unsplash.com/photo'],
        'user' => ['name' => 'Author', 'links' => ['html' => 'https://unsplash.com/@author']],
    ]],
    'missing attribution' => [[
        'links' => ['download_location' => 'https://api.unsplash.com/photos/photo/download'],
        'urls' => ['raw' => 'https://images.unsplash.com/photo'],
    ]],
]);
