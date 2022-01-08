<?php

use App\Models\Article;
use Database\Factories\ArticleFactory;
use Database\Factories\TagFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\CreatesUsers;
use Tests\TestCase;

uses(TestCase::class, CreatesUsers::class, DatabaseMigrations::class);

it('can store an article over the API', function (array $body, array $response) {
    $tag = TagFactory::new()->create();
    $user = $this->createUser();

    Sanctum::actingAs($user);

    $this->postJson(route('api.articles.store'), array_merge([
        'title' => 'Integrating with an API',
        'body' => '# Hello World',
        'tags' => [$tag->getKey()],
        'original_url' => 'https://laravel.com/docs/master/sanctum',
        'submitted' => false,
    ], $body))->assertJson(['data' => array_merge([
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
    ], $response)]);

    expect(Article::query()->count())->toBe(1);
})->with('article API responses');

it('can update an article over the API', function (array $body, array $response) {
    $tag = TagFactory::new()->create();
    $user = $this->createUser();

    Sanctum::actingAs($user);

    $article = ArticleFactory::new()->for($user, 'authorRelation')->create();

    $this->putJson(route('api.articles.update', $article->slug()), array_merge([
        'title' => 'Integrating with an API',
        'body' => '# Hello World',
        'tags' => [$tag->getKey()],
        'original_url' => 'https://laravel.com/docs/master/sanctum',
        'submitted' => false,
    ], $body))->assertJson(['data' => array_merge([
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
    ], $response)]);

    expect(Article::query()->count())->toBe(1);
})->with('article API responses');

it('can delete an article over the API', function () {
    $user = $this->createUser();
    Sanctum::actingAs($user);

    $article = ArticleFactory::new()->for($user, 'authorRelation')->create();

    $this->deleteJson(route('api.articles.delete', $article->slug()))
        ->assertNoContent();

    expect(Article::query()->count())->toBe(0);
});

it('does not allow a guest to create', function () {
    $this->postJson(route('api.articles.store'))
        ->assertUnauthorized();
});

it('does not allow a guest to update', function () {
    $this->putJson(route('api.articles.update', ArticleFactory::new()->create()->slug()))
        ->assertUnauthorized();
});

it('does not allow a user to update another user\'s article', function () {
    $user = $this->createUser();
    $article = ArticleFactory::new()->create();

    Sanctum::actingAs($user);

    $this->putJson(route('api.articles.update', $article->slug()), [
        'title' => 'Integrating with an API',
        'body' => '# Hello World',
        'submitted' => false,
    ])->assertForbidden();
});

it('does not allow a guest to delete', function () {
    $this->deleteJson(route('api.articles.delete', ArticleFactory::new()->create()->slug()))
        ->assertUnauthorized();
});

it('does not allow a user to delete another user\'s article', function () {
    $user = $this->createUser();
    $article = ArticleFactory::new()->create();

    Sanctum::actingAs($user);

    $this->deleteJson(route('api.articles.delete', $article->slug()))
        ->assertForbidden();
});

dataset('article API responses', [
    'default' => [[], []],
    'submitted for publishing' => [['submitted' => true], ['is_submitted' => true]],
    'no tags' => [['tags' => []], ['tags' => []]],
]);
