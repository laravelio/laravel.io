<?php

use App\Exceptions\UnsplashRequestFailed;
use App\UnsplashClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

uses(TestCase::class);

test('it searches photos', function () {
    Config::set('services.unsplash.access_key', 'test');

    Http::fake([
        'api.unsplash.com/search/photos*' => Http::response(fixture('Unsplash/search-photos.json')),
    ]);

    $response = app(UnsplashClient::class)->searchPhotos('coffee', 2);

    expect($response)->toBe(fixture('Unsplash/search-photos.json'));

    Http::assertSent(fn ($request) => $request->url() === 'https://api.unsplash.com/search/photos?query=coffee&page=2&per_page=12&orientation=landscape&content_filter=high'
        && $request->hasHeader('Authorization', 'Client-ID test'));
});

test('it finds a photo', function () {
    Config::set('services.unsplash.access_key', 'test');

    Http::fake([
        'api.unsplash.com/photos/eOLpJytrbsQ' => Http::response(fixture('Unsplash/photo.json')),
    ]);

    $photo = app(UnsplashClient::class)->findPhoto('eOLpJytrbsQ');

    expect($photo)->toBe(fixture('Unsplash/photo.json'));

    Http::assertSent(fn ($request) => $request->url() === 'https://api.unsplash.com/photos/eOLpJytrbsQ'
        && $request->hasHeader('Authorization', 'Client-ID test'));
});

test('it downloads a photo', function () {
    Config::set('services.unsplash.access_key', 'test');

    Http::fake([
        'api.unsplash.com/photos/eOLpJytrbsQ/download' => Http::response([]),
    ]);

    app(UnsplashClient::class)->downloadPhoto('https://api.unsplash.com/photos/eOLpJytrbsQ/download');

    Http::assertSent(fn ($request) => $request->url() === 'https://api.unsplash.com/photos/eOLpJytrbsQ/download'
        && $request->hasHeader('Authorization', 'Client-ID test'));
});

test('it throws an exception when photos cannot be searched', function () {
    Http::fake([
        'api.unsplash.com/search/photos*' => Http::response([], 500),
    ]);

    app(UnsplashClient::class)->searchPhotos('coffee');
})->throws(UnsplashRequestFailed::class);

test('it throws an exception when a photo cannot be found', function () {
    Http::fake([
        'api.unsplash.com/photos/eOLpJytrbsQ' => Http::response([], 404),
    ]);

    app(UnsplashClient::class)->findPhoto('eOLpJytrbsQ');
})->throws(UnsplashRequestFailed::class);

test('it throws an exception when the download endpoint fails', function () {
    Http::fake([
        'api.unsplash.com/photos/eOLpJytrbsQ/download' => Http::response([], 500),
    ]);

    app(UnsplashClient::class)->downloadPhoto('https://api.unsplash.com/photos/eOLpJytrbsQ/download');
})->throws(UnsplashRequestFailed::class);
