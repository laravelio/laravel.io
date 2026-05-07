<?php

use App\Console\Commands\UpdateArticleViewCounts;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

function fathomPageviewCount(string $url, ?int $pageviews): array
{
    $url = parse_url($url);

    return [
        'hostname' => "{$url['scheme']}://{$url['host']}",
        'pathname' => $url['path'],
        'pageviews' => $pageviews,
    ];
}

test('article view counts can be updated', function () {
    Http::fake(function () {
        return Http::response([
            fathomPageviewCount('http://localhost/articles/my-first-article', 1234),
        ]);
    });

    $article = Article::factory()->create([
        'title' => 'My First Article',
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new UpdateArticleViewCounts)->handle();

    expect($article->fresh()->view_count)->toBe(1234);
});

test('article updated timestamp is not touched when view counts are updated', function () {
    Http::fake(function () {
        return Http::response([
            fathomPageviewCount('http://localhost/articles/my-first-article', 1234),
        ]);
    });

    $article = Article::factory()->create([
        'title' => 'My First Article',
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
        'created_at' => '2022-08-03 12:00:00',
        'updated_at' => '2022-08-03 12:00:00',
    ]);

    (new UpdateArticleViewCounts)->handle();

    expect($article->fresh()->view_count)->toBe(1234);
    expect($article->fresh()->updated_at->toDateTimeString())->toBe('2022-08-03 12:00:00');
});

test('article view counts are not updated when API returns null', function () {
    Http::fake(function () {
        return Http::response([
            fathomPageviewCount('http://localhost/articles/my-first-article', null),
        ]);
    });

    $article = Article::factory()->create([
        'title' => 'My First Article',
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new UpdateArticleViewCounts)->handle();

    expect($article->fresh()->view_count)->toBeNull();
});

test('article view counts can be merged with original url', function () {
    Http::fake(function () {
        return Http::response([
            fathomPageviewCount('http://localhost/articles/my-first-article', 1234),
            fathomPageviewCount('https://example.com/my-first-article', 1234),
        ]);
    });

    $article = Article::factory()->create([
        'title' => 'My First Article',
        'slug' => 'my-first-article',
        'original_url' => 'https://example.com/my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new UpdateArticleViewCounts)->handle();

    expect($article->fresh()->view_count)->toBe(2468);
});

test('article view counts are not merged when url is invalid', function () {
    Http::fake(function () {
        return Http::response([
            fathomPageviewCount('http://localhost/articles/my-first-article', 1234),
        ]);
    });

    $article = Article::factory()->create([
        'title' => 'My First Article',
        'slug' => 'my-first-article',
        'original_url' => 'erhwerhwerh',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new UpdateArticleViewCounts)->handle();

    expect($article->fresh()->view_count)->toBe(1234);
});

test('article view counts are not overwritten if API call fails', function () {
    Http::fake(function () {
        return Http::response('Uh oh', 500);
    });

    $article = Article::factory()->create([
        'title' => 'My First Article',
        'slug' => 'my-first-article',
        'view_count' => 1234,
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new UpdateArticleViewCounts)->handle();

    Http::assertSentCount(3);

    expect($article->fresh()->view_count)->toBe(1234);
});

test('view counts are not updated for unpublished articles', function () {
    Http::fake();

    Article::factory()->create([
        'title' => 'My First Article',
        'slug' => 'my-first-article',
        'submitted_at' => now(),
    ]);

    (new UpdateArticleViewCounts)->handle();

    Http::assertNothingSent();
});

test('article view counts are fetched in batches', function () {
    Http::fake(function () {
        return Http::response([
            fathomPageviewCount('http://localhost/articles/my-first-article', 1234),
            fathomPageviewCount('http://localhost/articles/my-second-article', 4321),
        ]);
    });

    $firstArticle = Article::factory()->create([
        'title' => 'My First Article',
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    $secondArticle = Article::factory()->create([
        'title' => 'My Second Article',
        'slug' => 'my-second-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new UpdateArticleViewCounts)->handle();

    Http::assertSentCount(1);

    expect($firstArticle->fresh()->view_count)->toBe(1234);
    expect($secondArticle->fresh()->view_count)->toBe(4321);
});
