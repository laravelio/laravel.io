<?php

use App\Models\Article;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

function inProduction()
{
    App::detectEnvironment(fn () => 'production');
}

afterEach(fn () => App::detectEnvironment(fn () => 'testing'));

test('pages without a canonical url explicitly set fall back to the current url', function () {
    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost/register" />');

    $this->get('/register')
        ->assertSee($expectedHtml);
});

test('pages with a canonical url are rendered correctly', function () {
    $thread = Thread::factory()->create(['subject' => 'The first thread']);

    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost/forum/'.$thread->slug().'" />');

    $this->get("forum/{$thread->slug()}")
        ->assertSee($expectedHtml);
});

test('first page of paginated list removes page=1 from canonical url', function () {
    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost/forum?filter=recent" />');

    $this->get('forum?page=1')
        ->assertSee($expectedHtml);
});

test('subsequent pages of paginated list sets the full url as canonical', function () {
    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost/forum?filter=recent&amp;page=2" />');

    $this->get('forum?page=2')
        ->assertSee($expectedHtml);
});

test('allowed params are included in the canonical url', function () {
    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost/forum?filter=recent" />');

    $this->get('forum?filter=recent&page=1')
        ->assertSee($expectedHtml);
});

test('non allowed params are not included in the canonical url', function () {
    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost/forum?filter=recent&amp;page=2" />');

    $this->get('forum?filter=recent&utm_source=twitter&utm_medium=social&utm_term=abc123&page=2')
        ->assertSee($expectedHtml);
});

test('query_params_are_always_in_the_same_order', function () {
    Tag::factory()->create(['name' => 'Laravel', 'slug' => 'laravel']);

    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost/articles?filter=trending&amp;page=2&amp;tag=laravel" />');

    $this->get('articles?utm_source=twitter&utm_medium=social&utm_term=abc123&filter=trending&page=2&tag=laravel')
        ->assertSee($expectedHtml);
});

test('standard pages always remove query params from canonical url', function () {
    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost" />');

    $this->get('?utm_source=twitter&utm_medium=social&utm_term=abc123')
        ->assertSee($expectedHtml);
});

test('canonical tracking is turned off when using external url', function () {
    Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now(), 'original_url' => 'https://example.com/external-path']);

    $expectedHtml = new HtmlString('data-canonical="false"');

    $this->get('/articles/my-first-article')
        ->assertSee($expectedHtml);
})->inProduction();

test('canonical tracking is turned on when using external url', function () {
    App::detectEnvironment(fn () => 'production');

    Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now()]);

    $expectedHtml = new HtmlString('data-canonical="false"');

    $this->get('/articles/my-first-article')
        ->assertDontSee($expectedHtml);
})->inProduction();
