<?php

use App\Jobs\CreateArticle;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can create a draft article', function () {
    $user = $this->createUser();

    $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, false, [
        'original_url' => 'https://laravel.io',
    ]));

    $this->assertEquals('Title', $article->title());
    $this->assertEquals('Body', $article->body());
    $this->assertEquals('https://laravel.io', $article->canonicalUrl());
    $this->assertNull($article->submittedAt());
    $this->assertTrue($article->isNotPublished());
});

test('we can create an article and submit it for approval', function () {
    $user = $this->createUser();

    $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, true, [
        'original_url' => 'https://laravel.io',
    ]));

    $this->assertNotNull($article->submittedAt());
});
