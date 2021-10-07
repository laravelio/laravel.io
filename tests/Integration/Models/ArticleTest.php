<?php

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('we can get most popular articles', function () {
    $users = User::factory()->count(2)->create();
    $articles = Article::factory()->count(3)->create();

    // Like the second article twice.
    $articles[1]->likedBy($users[0]);
    $articles[1]->likedBy($users[1]);

    // Like the first article once.
    $articles[0]->likedBy($users[0]);

    $popularArticles = Article::popular()->get();

    expect($popularArticles[0]->title)->toEqual($articles[1]->title);
    expect($popularArticles[1]->title)->toEqual($articles[0]->title);
    expect($popularArticles[2]->title)->toEqual($articles[2]->title);
});

test('we can get trending articles', function () {
    $users = User::factory()->count(3)->create();
    $articles = Article::factory()->count(3)->create();

    // Like the first article by two users.
    $articles[0]->likedBy($users[0]);
    $articles[0]->likedBy($users[1]);

    // Update the like timestamp outside of the trending window.
    $articles[0]->likesRelation()->update(['created_at' => now()->subWeeks(2)]);
    $articles[0]->unsetRelation('likesRelation');

    // Like the remaining articles once, but inside the trending window.
    $articles[1]->likedBy($users[0]);
    $articles[2]->likedBy($users[0]);

    $trendingArticles = Article::trending()->get();

    // The first article has more likes, but outside the trending window
    // so should be returned last.
    expect($trendingArticles[0]->title)->toEqual($articles[1]->title);
    expect($trendingArticles[1]->title)->toEqual($articles[2]->title);
    expect($trendingArticles[2]->title)->toEqual($articles[0]->title);
});

test('pinned articles are returned first', function () {
    $articleOne = Article::factory()->create([
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);
    $articleTwo = Article::factory()->create([
        'submitted_at' => now()->subDay(),
        'approved_at' => now(),
    ]);
    $articleThree = Article::factory()->create([
        'submitted_at' => now()->subDays(3),
        'approved_at' => now(),
        'is_pinned' => true,
    ]);

    $recentArticles = Article::recent()->get();

    expect($recentArticles[0]->title)->toEqual($articleThree->title);
    expect($recentArticles[1]->title)->toEqual($articleOne->title);
    expect($recentArticles[2]->title)->toEqual($articleTwo->title);
});
