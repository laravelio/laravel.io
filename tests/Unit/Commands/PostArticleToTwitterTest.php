<?php

namespace Tests\Unit\Commands;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Support\Facades\Notification;
use App\Console\Commands\PostArticleToTwitter;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Notifications\PostArticleToTwitter as PostArticleToTwitterNotification;

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
            'submitted_at' => now(),
            'approved_at' => now(),
        ]);

        (new PostArticleToTwitter(new AnonymousNotifiable()))->handle();

        Notification::assertSentTo(
            new AnonymousNotifiable,
            PostArticleToTwitterNotification::class
        );

        $this->assertTrue($article->fresh()->isShared());
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
