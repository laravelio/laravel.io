<?php

use App\Console\Commands\PostArticleToSocialMedia;
use App\Models\Article;
use App\Notifications\PostArticleToBluesky;
use App\Notifications\PostArticleToTwitter;
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

    (new PostArticleToSocialMedia)->handle(new AnonymousNotifiable);

    Notification::assertSentTo(
        new AnonymousNotifiable,
        PostArticleToBluesky::class,
        function ($notification, $channels, $notifiable) use ($article) {
            $post = $notification->generatePost();

            return
                Str::contains($post, 'My First Article') &&
                Str::contains($post, route('articles.show', $article->slug()));
        },
    );

    Notification::assertSentTo(
        new AnonymousNotifiable,
        PostArticleToTwitter::class,
        function ($notification, $channels, $notifiable) use ($article) {
            $tweet = $notification->generateTweet();

            return
                Str::contains($tweet, 'My First Article') &&
                Str::contains($tweet, route('articles.show', $article->slug()));
        },
    );

    expect($article->fresh()->isShared())->toBeTrue();
});

test('articles are shared with twitter and bluesky handles', function () {
    $user = $this->createUser([
        'bluesky' => 'driesvints.com',
        'twitter' => '_joedixon',
    ]);

    Article::factory()->create([
        'author_id' => $user->id(),
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new PostArticleToSocialMedia)->handle(new AnonymousNotifiable);

    Notification::assertSentTo(
        new AnonymousNotifiable,
        PostArticleToBluesky::class,
        function ($notification, $channels, $notifiable) {
            return Str::contains($notification->generatePost(), '@driesvints.com');
        },
    );
    Notification::assertSentTo(
        new AnonymousNotifiable,
        PostArticleToTwitter::class,
        function ($notification, $channels, $notifiable) {
            return Str::contains($notification->generateTweet(), '@_joedixon');
        },
    );
});

test('articles are shared with name when no twitter or bluesky handles', function () {
    $user = $this->createUser([
        'name' => 'Joe Dixon',
        'bluesky' => null,
        'twitter' => null,
    ]);

    Article::factory()->create([
        'author_id' => $user->id(),
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    (new PostArticleToSocialMedia)->handle(new AnonymousNotifiable);

    Notification::assertSentTo(
        new AnonymousNotifiable,
        PostArticleToBluesky::class,
        function ($notification, $channels, $notifiable) {
            return Str::contains($notification->generatePost(), 'Joe Dixon');
        },
    );
    Notification::assertSentTo(
        new AnonymousNotifiable,
        PostArticleToTwitter::class,
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

    (new PostArticleToSocialMedia)->handle(new AnonymousNotifiable);

    Notification::assertNothingSent();
});

test('unapproved articles are not shared', function () {
    Article::factory()->create([
        'submitted_at' => now(),
    ]);

    (new PostArticleToSocialMedia)->handle(new AnonymousNotifiable);

    Notification::assertNothingSent();
});

test('unsubmitted articles are not shared', function () {
    Article::factory()->create();

    (new PostArticleToSocialMedia)->handle(new AnonymousNotifiable);

    Notification::assertNothingSent();
});
