<?php

use App\Models\Article;
use Database\Factories\TagFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\CreatesUsers;
use Tests\TestCase;

uses(TestCase::class, CreatesUsers::class, DatabaseMigrations::class);

it('can store an article over the API', function () {
    $tag = TagFactory::new()->create();
    $user = $this->createUser();

    Sanctum::actingAs($user);

    $this->postJson(route('api.articles.store'), [
        'title' => 'Integrating with an API',
        'body' => '# Hello World',
        'tags' => [$tag->getKey()],
        'original_url' => 'https://laravel.com/docs/master/sanctum',
        'submitted' => false,
    ])->assertJson(['data' => [
        'url' => route('articles.show', Article::query()->first()->slug()),
        'title' => 'Integrating with an API',
        'body' => '# Hello World',
        'original_url' => 'https://laravel.com/docs/master/sanctum',
        'author' => [
            'email' => $user->emailAddress(),
            'name' => $user->name(),
            'bio' => $user->bio(),
            'twitter_handle' => $user->twitter(),
            'github_username' => $user->githubUsername(),
        ],
        'tags' => [[
            'id' => $tag->getKey(),
            'name' => $tag->name(),
            'slug' => $tag->slug(),
        ]],
        'is_submitted' => false,
    ]]);
});
