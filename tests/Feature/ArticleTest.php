<?php

use App\Events\ArticleWasSubmittedForApproval;
use App\Jobs\SyncArticleImage;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\ArticleApprovedNotification;
use App\Notifications\ArticleSubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\HtmlString;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('users cannot create an article when not logged in', function () {
    $this->get('/articles/create')
        ->assertRedirect('/login');
});

test('users can create an article', function () {
    $user = $this->createUser();
    $tag = Tag::factory()->create(['name' => 'Test Tag']);

    $this->loginAs($user);

    $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'tags' => [$tag->id()],
        'submitted' => '0',
    ])
        ->assertRedirect('/articles/using-database-migrations')
        ->assertSessionHas('success', 'Article successfully created!');
});

test('user gets submitted message when submitting new article for approval', function () {
    Event::fake();

    $this->login();

    $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'tags' => [],
        'submitted' => '1',
    ])
        ->assertRedirect('/articles/using-database-migrations')
        ->assertSessionHas('success', 'Thank you for submitting, unfortunately we can\'t accept every submission. You\'ll only hear back from us when we accept your article.');

    Event::assertDispatched(ArticleWasSubmittedForApproval::class);
});

test('users can submit an article for approval', function () {
    Event::fake();

    $this->login();

    $response = $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '1',
    ])
        ->assertRedirect('/articles/using-database-migrations');

    $this->followRedirects($response)
        ->assertDontSee('Draft')
        ->assertSee('Awaiting Approval');

    Event::assertDispatched(ArticleWasSubmittedForApproval::class);
});

test('articles submitted for approval sends a telegram notification for review', function () {
    Notification::fake();

    $this->login();

    $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '1',
    ]);

    Notification::assertSentOnDemand(ArticleSubmitted::class);
});

test('users can create a draft article', function () {
    $this->login();

    $response = $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '0',
    ])
        ->assertRedirect('/articles/using-database-migrations');

    $this->followRedirects($response)
        ->assertSee('Draft');
});

test('draft articles do not send telegram notification', function () {
    Notification::fake();

    $this->login();

    $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '0',
    ]);

    Notification::assertNothingSent();
});

test('users cannot create an article with a title that is too long', function () {
    $this->login();

    $response = $this->post('/articles', [
        'title' => 'Adding Notifications to make a really engaging UI for Laravel.io users using Livewire, Alpine.js and Tailwind UI',
        'body' => 'The title of this article is too long',
    ]);

    $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
    $response->assertSessionHasErrors(['title' => 'The title must not be greater than 100 characters.']);
});

test('an article may not contain an http image url', function () {
    $this->login();

    $response = $this->post('/articles', [
        'title' => 'My First Article',
        'body' => 'This is a really interesting article about images. Here is ![an image](http://example.com/image.jpg).',
    ]);

    $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
    $response->assertSessionHasErrors(['body' => 'The body field contains at least one image with an HTTP link.']);
});

test('guests can view an article', function () {
    $article = Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now()]);

    $this->get('/articles/my-first-article')
        ->assertSee($article->title());
});

test('articles with links do not include a nofollow attributes', function () {
    $article = Article::factory()->approved()->create([
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'body' => 'This article will go into depth on working with database migrations. Here is [a link](https://example.com).',
    ]);

    $this->get('/articles/my-first-article')
        ->assertSee($article->title())
        ->assertDontSee('nofollow');
});

test('logged in users can view an article', function () {
    $article = Article::factory()->create([
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    $this->login();

    $this->get('/articles/my-first-article')
        ->assertSee($article->title());
});

test('users can edit an article', function () {
    $user = $this->createUser();
    $tag = Tag::factory()->create(['name' => 'Test Tag']);

    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
    ]);

    $this->loginAs($user);

    $this->put('/articles/my-first-article', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'tags' => [$tag->id()],
        'submitted' => '0',
    ])
        ->assertRedirect('/articles/using-database-migrations')
        ->assertSessionHas('success', 'Article successfully updated!');
});

test('editing a draft article does not send telegram notification', function () {
    Notification::fake();

    $user = $this->createUser();
    $tag = Tag::factory()->create(['name' => 'Test Tag']);

    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
    ]);

    $this->loginAs($user);

    $this->put('/articles/my-first-article', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'tags' => [$tag->id()],
        'submitted' => '0',
    ]);

    Notification::assertNothingSent();
});

test('user gets submitted message when submitting existing article for approval', function () {
    Event::fake();

    $user = $this->createUser();

    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
    ]);

    $this->loginAs($user);

    $this->put('/articles/my-first-article', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'tags' => [],
        'submitted' => '1',
    ])
        ->assertRedirect('/articles/using-database-migrations')
        ->assertSessionHas('success', 'Thank you for submitting, unfortunately we can\'t accept every submission. You\'ll only hear back from us when we accept your article.');

    Event::assertDispatched(ArticleWasSubmittedForApproval::class);
});

test('users can submit an existing article for approval', function () {
    Event::fake();

    $user = $this->createUser();

    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
        'submitted_at' => null,
    ]);

    $this->loginAs($user);

    $response = $this->put('/articles/my-first-article', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '1',
    ])
        ->assertRedirect('/articles/using-database-migrations');

    $this->followRedirects($response)
        ->assertDontSee('Draft');

    Event::assertDispatched(ArticleWasSubmittedForApproval::class);
});

test('notification is sent to telegram when existing article is submitted for approval', function () {
    Notification::fake();

    $user = $this->createUser();

    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
    ]);

    $this->loginAs($user);

    $this->put('/articles/my-first-article', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'tags' => [],
        'submitted' => '1',
    ]);

    Notification::assertSentOnDemand(ArticleSubmitted::class);
});

test('users cannot edit an article with a title that is too long', function () {
    $user = $this->createUser();
    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
    ]);

    $this->loginAs($user);

    $response = $this->put('/articles/my-first-article', [
        'title' => 'Adding Notifications to make a really engaging UI for Laravel.io users using Livewire, Alpine.js and Tailwind UI',
        'body' => 'The title of this article is too long',
    ]);

    $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
    $response->assertSessionHasErrors(['title' => 'The title must not be greater than 100 characters.']);
});

test('an article may not updated to contain an http image url', function () {
    $user = $this->createUser();
    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
    ]);

    $this->loginAs($user);

    $response = $this->put('/articles/my-first-article', [
        'title' => 'My first article',
        'body' => 'This is a really interesting article about images. Here is ![an image](http://example.com/image.jpg).',
    ]);

    $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
    $response->assertSessionHasErrors(['body' => 'The body field contains at least one image with an HTTP link.']);
});

test('an already submitted article should not have timestamp updated on update', function () {
    $user = $this->createUser();
    $article = Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
        'submitted_at' => '2020-06-19 00:00:00',
    ]);

    $this->loginAs($user);

    $this->put('/articles/my-first-article', [
        'title' => 'My first article',
        'body' => 'Just updating the body of the article',
        'submitted' => true,
    ]);

    expect($article->fresh()->submittedAt()->format('Y-m-d H:i:s'))->toBe('2020-06-19 00:00:00');
});

test('users can delete their own articles', function () {
    $user = $this->createUser();
    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
        'is_sponsored' => false,
    ]);

    $this->loginAs($user);

    $this->delete('/articles/my-first-article')
        ->assertRedirect('/articles')
        ->assertSessionHas('success', 'Article successfully deleted!');
});

test('users cannot delete an article they do not own', function () {
    Article::factory()->create(['slug' => 'my-first-article']);

    $this->login();

    $this->delete('/articles/my-first-article')
        ->assertForbidden();
});

test('users cannot delete an article that is sponsored', function () {
    $user = $this->createUser();
    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
        'is_sponsored' => true,
    ]);

    $this->loginAs($user);

    $this->delete('/articles/my-first-article')
        ->assertForbidden();
});

test('canonical urls are rendered', function () {
    Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now()]);

    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost/articles/my-first-article" />');

    $this->get('/articles/my-first-article')
        ->assertSee($expectedHtml);
});

test('custom canonical urls are rendered', function () {
    Article::factory()->create([
        'slug' => 'my-first-article',
        'original_url' => 'https://joedixon.co.uk/my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    $expectedHtml = new HtmlString('<link rel="canonical" href="https://joedixon.co.uk/my-first-article" />');

    $this->get('/articles/my-first-article')
        ->assertSee($expectedHtml);
});

test('draft articles cannot be viewed by guests', function () {
    Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => null]);

    $this->get('/articles/my-first-article')
        ->assertStatus(404);
});

test('draft articles can be viewed by the article owner', function () {
    $user = $this->createUser();
    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
        'submitted_at' => null,
    ]);

    $this->loginAs($user);

    $this->get('/articles/my-first-article')
        ->assertStatus(200)
        ->assertSee('Draft');
});

test('draft articles cannot be viewed by logged in users', function () {
    Article::factory()->create([
        'slug' => 'my-first-article',
        'submitted_at' => null,
    ]);

    $this->login();

    $this->get('/articles/my-first-article')
        ->assertStatus(404);
});

test('a user can view their articles', function () {
    $user = $this->createUser();

    $articles = Article::factory()->count(3)->create([
        'author_id' => $user->id,
    ]);

    $this->loginAs($user);

    $this->get('/articles/authored')
        ->assertSee($articles[0]->title())
        ->assertSee($articles[1]->title())
        ->assertSee($articles[2]->title());
});

test("a user cannot view another user's articles", function () {
    $articles = Article::factory()->count(3)->create();

    $this->login();

    $this->get('/articles/authored')
        ->assertDontSee($articles[0]->title())
        ->assertDontSee($articles[1]->title())
        ->assertDontSee($articles[2]->title());
});

test('a guest cannot see articles', function () {
    $this->get('/articles/authored')
        ->assertRedirect('/login');
});

test('users get a mail notification when their article is approved', function () {
    Notification::fake();

    $user = $this->createUser([
        'name' => 'Joe Dixon',
        'username' => 'joedixon',
        'email' => 'hello@joedixon.co.uk',
    ]);
    $article = Article::factory()->create([
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'author_id' => $user->id,
    ]);

    $this->loginAsAdmin();
    $this->put("/admin/articles/{$article->slug()}/approve");

    Notification::assertSentTo($user, ArticleApprovedNotification::class);
});

test('tags are not rendered for unpublished articles', function () {
    $tag = Tag::factory()->create(['name' => 'Test Tag']);
    $article = Article::factory()->create([
        'slug' => 'my-first-article',
        'submitted_at' => now(),
    ]);
    $article->syncTags([$tag->id]);

    $this->get('/articles')
        ->assertDontSee('Test Tag');
});

test('share image url is rendered correctly', function () {
    Article::factory()->create([
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    $this->get('/articles/my-first-article')
        ->assertSee('articles/my-first-article/social.png')
        ->assertDontSee('images/laravelio-share.png');
});

test('default share image is used on non article pages', function () {
    $this->get('/')
        ->assertSee('images/laravelio-share.png')
        ->assertDontSee('articles/my-first-article/social.png');
});

test('user see a tip if they have not set the twitter handle', function () {
    $this->login(['twitter' => null]);

    $this->get('/articles/authored')
        ->assertSeeText('X (Twitter) and/or Bluesky handles', '<a>')
        ->assertSee('so we can link to your profiles when we tweet out your article.');
});

test('user see a tip if they have not set the bluesky handle', function () {
    $this->login(['bluesky' => null]);

    $this->get('/articles/authored')
        ->assertSeeText('X (Twitter) and/or Bluesky handles', '<a>')
        ->assertSee('so we can link to your profiles when we tweet out your article.');
});

test('user do not see tip if they have set the twitter handle', function () {
    $this->login();

    $this->get('/articles/authored')
        ->assertDontSeeText('X (Twitter) and/or Bluesky handles', '<a>')
        ->assertDontSee('so we can link to your profiles when we tweet out your article.');
});

test('loading page with invalid sort parameter defaults to recent', function () {
    Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now()]);

    $expectedHtml = new HtmlString('<link rel="canonical" href="http://localhost/articles?filter=recent" />');

    $this->get('/articles?filter=invalid')
        ->assertSee($expectedHtml);
});

test('can filter articles by tag', function () {
    $articleOne = Article::factory()->create(['title' => 'My First Article', 'slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now()]);
    $tagOne = Tag::factory()->create(['slug' => 'one']);
    $articleOne->syncTags([$tagOne->id]);

    $articleTwo = Article::factory()->create(['title' => 'My Second Article', 'slug' => 'my-second-article', 'submitted_at' => now(), 'approved_at' => now()]);
    $tagTwo = Tag::factory()->create(['slug' => 'two']);
    $articleTwo->syncTags([$tagTwo->id]);

    $this->get('/articles?tag=one')
        ->assertSee('My First Article')
        ->assertDontSee('My Second Article');
});

test('only articles with ten or more views render a view count', function () {
    $article = Article::factory()->create([
        'title' => 'My First Article',
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
        'view_count' => 9,
    ]);

    $this->get("/articles/{$article->slug()}")
        ->assertSee('My First Article')
        ->assertDontSee('9 views');

    $article->update(['view_count' => 10]);

    $this->get("/articles/{$article->slug()}")
        ->assertSee('My First Article')
        ->assertSee('10 views');
});

test('verified authors can publish two articles per day with no approval needed', function () {
    $author = $this->createUser(userFactory: User::factory()->verifiedAuthor());

    Article::factory()->count(2)->create([
        'author_id' => $author->id,
        'submitted_at' => now()->addMinutes(1), // after verification
    ]);

    expect($author->canVerifiedAuthorPublishMoreArticlesToday())->toBeFalse();
});

test('verified authors skip the approval message when submitting new article', function () {
    Bus::fake(SyncArticleImage::class);

    $author = $this->createUser(userFactory: User::factory()->verifiedAuthor());
    $this->loginAs($author);

    $response = $this->post('/articles', [
        'title' => 'Using database migrations',
        'hero_image_id' => 'NoiJZhDF4Es',
        'body' => 'This article will go into depth on working with database migrations.',
        'tags' => [],
        'submitted' => '1',
    ]);

    $response
        ->assertRedirect('/articles/using-database-migrations')
        ->assertSessionMissing('success');

    Bus::assertDispatched(SyncArticleImage::class, function (SyncArticleImage $job) {
        return $job->article->hero_image_id === 'NoiJZhDF4Es';
    });
});
