<?php

namespace Tests\Unit\Commands;

use App\Console\Commands\PostArticleToTwitter;
use App\Models\Article;
use App\Notifications\PostArticleToTwitter as PostArticleToTwitterNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostArticleToTwitterTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    /** @test */
    public function published_articles_can_be_shared_on_twitter()
    {
        $article = factory(Article::class)->create([
            'title' => 'My First Article',
            'submitted_at' => now(),
            'approved_at' => now(),
        ]);

        (new PostArticleToTwitter(new AnonymousNotifiable()))->handle();

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            PostArticleToTwitterNotification::class,
            function ($notification, $channels, $notifiable) use ($article) {
                $tweet = $notification->generateTweet();
                return Str::contains($tweet, 'My First Article') &&
                Str::contains($tweet, route('articles.show', $article->slug()));
            }
        );

        $this->assertTrue($article->fresh()->isShared());
    }

    /** @test */
    public function articles_are_shared_with_twitter_handle()
    {
        $user = $this->createUser([
            'twitter_handle' => '_joedixon',
        ]);

        factory(Article::class)->create([
            'author_id' => $user->id(),
            'submitted_at' => now(),
            'approved_at' => now(),
        ]);

        (new PostArticleToTwitter(new AnonymousNotifiable()))->handle();

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            PostArticleToTwitterNotification::class,
            function ($notification, $channels, $notifiable) use ($user) {
                return Str::contains($notification->generateTweet(), '@_joedixon');
            }
        );
    }

    /** @test */
    public function articles_are_shared_with_name_when_no_twitter_handle()
    {
        $user = $this->createUser([
            'name' => 'Joe Dixon',
        ]);

        factory(Article::class)->create([
            'author_id' => $user->id(),
            'submitted_at' => now(),
            'approved_at' => now(),
        ]);

        (new PostArticleToTwitter(new AnonymousNotifiable()))->handle();

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            PostArticleToTwitterNotification::class,
            function ($notification, $channels, $notifiable) use ($user) {
                return Str::contains($notification->generateTweet(), 'Joe Dixon');
            }
        );
    }

    /** @test */
    public function already_shared_articles_are_not_shared_again()
    {
        factory(Article::class)->create([
            'submitted_at' => now(),
            'approved_at' => now(),
            'shared_at' => now(),
        ]);

        (new PostArticleToTwitter(new AnonymousNotifiable()))->handle();

        Notification::assertNothingSent();
    }

    /** @test */
    public function unapproved_articles_are_not_shared()
    {
        factory(Article::class)->create([
            'submitted_at' => now(),
        ]);

        (new PostArticleToTwitter(new AnonymousNotifiable()))->handle();

        Notification::assertNothingSent();
    }

    /** @test */
    public function unsubmitted_articles_are_not_shared()
    {
        factory(Article::class)->create();

        (new PostArticleToTwitter(new AnonymousNotifiable()))->handle();

        Notification::assertNothingSent();
    }
}
