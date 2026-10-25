<?php

use Mockery\MockInterface;
use Spatie\Sitemap\SitemapGenerator;
use Tests\TestCase;

uses(TestCase::class);

test('sitemap crawl filter accepts URL strings and excludes private paths', function () {
    $this->mock(SitemapGenerator::class, function (MockInterface $mock) {
        $mock->shouldReceive('setUrl')->once()->with(config('app.url'))->andReturnSelf();
        $mock->shouldReceive('shouldCrawl')->once()->withArgs(function (callable $filter) {
            expect($filter('https://laravel.io/articles'))->toBeTrue()
                ->and($filter('https://laravel.io/forum/a-thread'))->toBeFalse()
                ->and($filter('https://laravel.io/login/github'))->toBeFalse()
                ->and($filter('https://laravel.io/user/example'))->toBeFalse()
                ->and($filter('https://laravel.io'))->toBeFalse();

            return true;
        })->andReturnSelf();
        $mock->shouldReceive('hasCrawled')->once()->andReturnSelf();
        $mock->shouldReceive('writeToFile')->once()->with(public_path('sitemap.xml'))->andReturnSelf();
    });

    $this->artisan('lio:generate-sitemap')->assertSuccessful();
});
