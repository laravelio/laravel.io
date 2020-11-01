<?php

namespace Tests\Integration\Models;

use App\Models\Article;
use App\Models\Series;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_get_most_popular_articles()
    {
        $users = factory(User::class, 2)->create();
        $articles = factory(Article::class, 3)->create();

        // Like the second article twice.
        $articles[1]->likedBy($users[0]);
        $articles[1]->likedBy($users[1]);

        // Like the first article once.
        $articles[0]->likedBy($users[0]);

        $popularArticles = Article::popular()->get();

        $this->assertEquals($articles[1]->title, $popularArticles[0]->title);
        $this->assertEquals($articles[0]->title, $popularArticles[1]->title);
        $this->assertEquals($articles[2]->title, $popularArticles[2]->title);
    }

    /** @test */
    public function we_can_get_trending_articles()
    {
        $users = factory(User::class, 3)->create();
        $articles = factory(Article::class, 3)->create();

        // Like the first article by two users.
        $articles[0]->likedBy($users[0]);
        $articles[0]->likedBy($users[1]);

        // Update the like timestamp outside of the trending window.
        $articles[0]->likes()->update(['created_at' => now()->subWeeks(2)]);

        // Like the remaining articles once, but inside the trending window.
        $articles[1]->likedBy($users[0]);
        $articles[2]->likedBy($users[0]);

        $trendingArticles = Article::trending()->get();

        // The first article has more likes, but outside the trending window
        // so should be returned last.
        $this->assertEquals($articles[1]->title, $trendingArticles[0]->title);
        $this->assertEquals($articles[2]->title, $trendingArticles[1]->title);
        $this->assertEquals($articles[0]->title, $trendingArticles[2]->title);
    }

    /** @test */
    public function we_can_get_the_next_article_in_a_series()
    {
        $series = factory(Series::class)->create();
        $articleOne = factory(Article::class)->create([
            'submitted_at' => now()->subDays(2),
            'approved_at' => now(),
            'series_id' => $series->id,
        ]);
        $articleTwo = factory(Article::class)->create([
            'submitted_at' => now()->subDay(),
            'approved_at' => now(),
            'series_id' => $series->id,
        ]);
        $articleThree = factory(Article::class)->create([
            'submitted_at' => now(),
            'approved_at' => now(),
            'series_id' => $series->id,
        ]);

        $this->assertEquals($articleTwo->id, $articleOne->nextInSeries()->id);
        $this->assertEquals($articleThree->id, $articleTwo->nextInSeries()->id);
        $this->assertNull($articleThree->nextInSeries());
    }

    /** @test */
    public function we_can_get_the_previous_article_in_a_series()
    {
        $series = factory(Series::class)->create();
        $articleOne = factory(Article::class)->create([
            'submitted_at' => now()->subDays(2),
            'approved_at' => now(),
            'series_id' => $series->id,
        ]);
        $articleTwo = factory(Article::class)->create([
            'submitted_at' => now()->subDay(),
            'approved_at' => now(),
            'series_id' => $series->id,
        ]);
        $articleThree = factory(Article::class)->create([
            'submitted_at' => now(),
            'approved_at' => now(),
            'series_id' => $series->id,
        ]);

        $this->assertNull($articleOne->previousInSeries());
        $this->assertEquals($articleTwo->id, $articleThree->previousInSeries()->id);
        $this->assertEquals($articleOne->id, $articleTwo->previousInSeries()->id);
    }

    /** @test */
    public function pinned_articles_are_returned_first()
    {
        $articleOne = factory(Article::class)->create([
            'submitted_at' => now(),
            'approved_at' => now(),
        ]);
        $articleTwo = factory(Article::class)->create([
            'submitted_at' => now()->subDay(),
            'approved_at' => now(),
        ]);
        $articleThree = factory(Article::class)->create([
            'submitted_at' => now()->subDays(3),
            'approved_at' => now(),
            'is_pinned' => true,
        ]);

        $recentArticles = Article::recent()->get();

        $this->assertEquals($articleThree->title, $recentArticles[0]->title);
        $this->assertEquals($articleOne->title, $recentArticles[1]->title);
        $this->assertEquals($articleTwo->title, $recentArticles[2]->title);
    }
}
