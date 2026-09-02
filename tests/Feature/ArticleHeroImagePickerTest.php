<?php

use App\Livewire\ArticleHeroImagePicker;
use App\Models\Article;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

uses(TestCase::class);

test('it searches unsplash images', function () {
    Config::set('services.unsplash.access_key', 'test');

    Cache::shouldReceive('get')
        ->once()
        ->with(unsplashSearchCacheKey('coffee', 1))
        ->andReturn(null);
    Cache::shouldReceive('put')->once()->andReturnTrue();

    Http::fake([
        'api.unsplash.com/search/photos*' => Http::response(fixture('Unsplash/search-photos.json')),
    ]);

    Livewire::test(ArticleHeroImagePicker::class)
        ->set('query', 'coffee')
        ->assertSet('isOpen', true)
        ->assertSet('hasSearched', true)
        ->assertSet('page', 1)
        ->assertSet('totalPages', 7)
        ->assertDispatched('unsplash-images-updated')
        ->assertSee('Jeff Sheldon');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.unsplash.com/search/photos?query=coffee&page=1&per_page=12&orientation=landscape&content_filter=high'
            && $request->hasHeader('Authorization', 'Client-ID test');
    });
});

test('it loads more unsplash images', function () {
    Cache::shouldReceive('get')
        ->twice()
        ->andReturn(null, null);
    Cache::shouldReceive('put')->twice()->andReturnTrue();

    Http::fake([
        'api.unsplash.com/search/photos?query=coffee&page=1&per_page=12&orientation=landscape&content_filter=high' => Http::response(fixture('Unsplash/search-photos.json')),
        'api.unsplash.com/search/photos?query=coffee&page=2&per_page=12&orientation=landscape&content_filter=high' => Http::response(fixture('Unsplash/search-photos-page-2.json')),
    ]);

    Livewire::test(ArticleHeroImagePicker::class)
        ->set('query', 'coffee')
        ->assertSet('page', 1)
        ->assertSet('totalPages', 7)
        ->assertSet('isLoadingMore', false)
        ->call('loadMore')
        ->assertSet('page', 2)
        ->assertSet('totalPages', 7)
        ->assertSet('isLoadingMore', false)
        ->assertSee('Jeff Sheldon')
        ->assertSee('Annie Spratt');

    Http::assertSentCount(2);
});

test('it caches each unsplash search page', function () {
    Cache::shouldReceive('get')
        ->times(4)
        ->andReturn(
            null,
            null,
            fixture('Unsplash/search-photos.json'),
            fixture('Unsplash/search-photos-page-2.json'),
        );
    Cache::shouldReceive('put')->twice()->andReturnTrue();

    Http::fake([
        'api.unsplash.com/search/photos?query=coffee&page=1&per_page=12&orientation=landscape&content_filter=high' => Http::response(fixture('Unsplash/search-photos.json')),
        'api.unsplash.com/search/photos?query=coffee&page=2&per_page=12&orientation=landscape&content_filter=high' => Http::response(fixture('Unsplash/search-photos-page-2.json')),
    ]);

    Livewire::test(ArticleHeroImagePicker::class)
        ->set('query', 'coffee')
        ->call('loadMore');

    Livewire::test(ArticleHeroImagePicker::class)
        ->set('query', 'coffee')
        ->call('loadMore');

    Http::assertSentCount(2);
});

test('it does not search unsplash until the query has three characters', function () {
    Http::fake();

    Livewire::test(ArticleHeroImagePicker::class)
        ->set('query', 'co')
        ->assertSet('isOpen', false)
        ->assertSet('hasSearched', false);

    Http::assertNothingSent();
});

test('it caches unsplash searches', function () {
    Cache::shouldReceive('get')
        ->twice()
        ->andReturn(null, fixture('Unsplash/search-photos.json'));
    Cache::shouldReceive('put')->once()->andReturnTrue();

    Http::fake([
        'api.unsplash.com/search/photos*' => Http::response(fixture('Unsplash/search-photos.json')),
    ]);

    Livewire::test(ArticleHeroImagePicker::class)->set('query', 'coffee');
    Livewire::test(ArticleHeroImagePicker::class)
        ->set('query', 'coffee')
        ->assertDispatched('unsplash-images-updated');

    Http::assertSentCount(1);
});

test('it shows an error when unsplash cannot be reached', function () {
    Cache::shouldReceive('get')
        ->once()
        ->with(unsplashSearchCacheKey('coffee', 1))
        ->andReturn(null);
    Cache::shouldReceive('put')->never();

    Http::fake([
        'api.unsplash.com/search/photos*' => Http::response([], 500),
    ]);

    Livewire::test(ArticleHeroImagePicker::class)
        ->set('query', 'coffee')
        ->assertSet('isOpen', true)
        ->assertSet('hasSearched', true)
        ->assertSee('We could not load images from Unsplash. Please try again.');
});

test('it selects an unsplash image', function () {
    Cache::shouldReceive('get')
        ->once()
        ->with(unsplashSearchCacheKey('coffee', 1))
        ->andReturn(null);
    Cache::shouldReceive('put')->once()->andReturnTrue();

    Http::fake([
        'api.unsplash.com/search/photos*' => Http::response(fixture('Unsplash/search-photos.json')),
    ]);

    Livewire::test(ArticleHeroImagePicker::class)
        ->set('query', 'coffee')
        ->call('selectImage', 'eOLpJytrbsQ')
        ->assertSet('selectedImageId', 'eOLpJytrbsQ')
        ->assertSet('query', '')
        ->assertSet('images', [])
        ->assertSet('hasSearched', false)
        ->assertSet('isOpen', false)
        ->assertSee('Photo by')
        ->assertSee('Jeff Sheldon')
        ->assertSee('Unsplash');
});

test('it renders an existing article image', function () {
    $article = new Article([
        'hero_image_id' => 'eOLpJytrbsQ',
        'hero_image_url' => 'https://images.unsplash.com/photo-1416339306562-f3d12fefd36f',
        'hero_image_author_name' => 'Jeff Sheldon',
        'hero_image_author_url' => 'https://unsplash.com/@ugmonk',
    ]);

    Livewire::test(ArticleHeroImagePicker::class, ['article' => $article])
        ->assertSet('selectedImageId', 'eOLpJytrbsQ')
        ->assertSee('Jeff Sheldon');
});

function unsplashSearchCacheKey(string $query, int $page): string
{
    return 'unsplash-search:'.md5(strtolower($query)).":page:{$page}";
}
