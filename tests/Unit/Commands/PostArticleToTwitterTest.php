<?php

use App\Console\Commands\PostArticleToTwitter;
use App\Models\Article;
use App\Notifications\PostArticleToTwitter as PostArticleToTwitterNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

beforeEach(function () {
    Notification::fake();
});

test('published articles can be shared on twitter', function () {
    $article = Article::factory()->create([
        'title' => 'My First Article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new PostArticleToTwitter())->handle(new AnonymousNotifiable());

    Notification::assertSentTo(
        new AnonymousNotifiable(),
        PostArticleToTwitterNotification::class,
        function ($notification, $channels, $notifiable) use ($article) {
            $tweet = $notification->generateTweet();

            return
                Str::contains($tweet, 'My First Article') &&
                Str::contains($tweet, route('articles.show', $article->slug()));
        },
    );

    expect($article->fresh()->isShared())->toBeTrue();
});

test('articles are shared with twitter handle', function () {
    $user = $this->createUser([
        'twitter' => '_joedixon',
    ]);

    Article::factory()->create([
        'author_id' => $user->id(),
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new PostArticleToTwitter())->handle(new AnonymousNotifiable());

    Notification::assertSentTo(
        new AnonymousNotifiable(),
        PostArticleToTwitterNotification::class,
        function ($notification, $channels, $notifiable) {
            return Str::contains($notification->generateTweet(), '@_joedixon');
        },
    );
});

test('articles are shared with name when no twitter handle', function () {
    $user = $this->createUser([
        'name' => 'Joe Dixon',
        'twitter' => null,
    ]);

    Article::factory()->create([
        'author_id' => $user->id(),
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new PostArticleToTwitter())->handle(new AnonymousNotifiable());

    Notification::assertSentTo(
        new AnonymousNotifiable(),
        PostArticleToTwitterNotification::class,
        function ($notification, $channels, $notifiable) {
            return Str::contains($notification->generateTweet(), 'Joe Dixon');
        },
    );
});

test('already shared articles are not shared again', function () {
    Article::factory()->create([
        'submitted_at' => now(),
        'approved_at' => now(),
        'shared_at' => now(),
    ]);

    (new PostArticleToTwitter())->handle(new AnonymousNotifiable());

    Notification::assertNothingSent();
});

test('unapproved articles are not shared', function () {
    Article::factory()->create([
        'submitted_at' => now(),
    ]);

    (new PostArticleToTwitter())->handle(new AnonymousNotifiable());

    Notification::assertNothingSent();
});

test('unsubmitted articles are not shared', function () {
    Article::factory()->create();

    (new PostArticleToTwitter())->handle(new AnonymousNotifiable());

    Notification::assertNothingSent();
});
