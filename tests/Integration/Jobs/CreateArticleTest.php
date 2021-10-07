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

    expect($article->title())->toEqual('Title');
    expect($article->body())->toEqual('Body');
    expect($article->canonicalUrl())->toEqual('https://laravel.io');
    expect($article->submittedAt())->toBeNull();
    expect($article->isNotPublished())->toBeTrue();
});

test('we can create an article and submit it for approval', function () {
    $user = $this->createUser();

    $article = $this->dispatch(new CreateArticle('Title', 'Body', $user, true, [
        'original_url' => 'https://laravel.io',
    ]));

    $this->assertNotNull($article->submittedAt());
});
