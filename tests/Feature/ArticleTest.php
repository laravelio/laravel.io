<?php

use App\Events\ArticleWasSubmittedForApproval;
use App\Models\Article;
use App\Models\Tag;
use App\Notifications\ArticleApprovedNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('users cannot create an article when not logged in', function () {
    $this->visit('/articles/create')
        ->seePageIs('/login');
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
        ->assertRedirectedTo('/articles/using-database-migrations')
        ->assertSessionHas('success', 'Article successfully created!');
});

test('user gets submitted message when submitting new article for approval', function () {
    $this->login();

    $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'tags' => [],
        'submitted' => '1',
    ])
        ->assertRedirectedTo('/articles/using-database-migrations')
        ->assertSessionHas('success', 'Thank you for submitting, unfortunately we can\'t accept every submission. You\'ll only hear back from us when we accept your article.');
});

test('users can submit an article for approval', function () {
    $this->login();

    $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '1',
    ])
        ->assertRedirectedTo('/articles/using-database-migrations')
        ->followRedirects()
        ->dontSee('Draft')
        ->see('Awaiting approval');
});

test('articles submitted for approval send telegram notification', function () {
    Event::fake();
    $this->login();

    $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '1',
    ]);

    Event::assertDispatched(ArticleWasSubmittedForApproval::class);
});

test('users can create a draft article', function () {
    $this->login();

    $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '0',
    ])
        ->assertRedirectedTo('/articles/using-database-migrations')
        ->followRedirects()
        ->see('Draft');
});

test('draft articles do not send telegram notification', function () {
    Event::fake();
    $this->login();

    $this->post('/articles', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '0',
    ]);

    Event::assertNotDispatched(ArticleWasSubmittedForApproval::class);
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
        ->see($article->title());
});

test('logged in users can view an article', function () {
    $article = Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now()]);

    $this->login();

    $this->get('/articles/my-first-article')
        ->see($article->title());
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
        ->assertRedirectedTo('/articles/using-database-migrations')
        ->assertSessionHas('success', 'Article successfully updated!');
});

test('editing a draft article does not send telegram notification', function () {
    Event::fake();
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

    Event::assertNotDispatched(ArticleWasSubmittedForApproval::class);
});

test('user gets submitted message when submitting existing article for approval', function () {
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
        ->assertRedirectedTo('/articles/using-database-migrations')
        ->assertSessionHas('success', 'Thank you for submitting, unfortunately we can\'t accept every submission. You\'ll only hear back from us when we accept your article.');
});

test('users can submit an existing article for approval', function () {
    $user = $this->createUser();

    Article::factory()->create([
        'author_id' => $user->id(),
        'slug' => 'my-first-article',
        'submitted_at' => null,
    ]);

    $this->loginAs($user);

    $this->put('/articles/my-first-article', [
        'title' => 'Using database migrations',
        'body' => 'This article will go into depth on working with database migrations.',
        'submitted' => '1',
    ])
        ->assertRedirectedTo('/articles/using-database-migrations')
        ->followRedirects()
        ->dontSee('Draft');
});

test('notification is sent to telegram when existing article is submitted for approval', function () {
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
    ]);

    Event::assertDispatched(ArticleWasSubmittedForApproval::class);
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
    ]);

    $this->loginAs($user);

    $this->delete('/articles/my-first-article')
        ->assertRedirectedTo('/articles')
        ->assertSessionHas('success', 'Article successfully deleted!');
});

test('users cannot delete an article they do not own', function () {
    Article::factory()->create(['slug' => 'my-first-article']);

    $this->login();

    $this->delete('/articles/my-first-article')
        ->assertForbidden();
});

test('canonical urls are rendered', function () {
    Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now()]);

    $this->get('/articles/my-first-article')
        ->see('<link rel="canonical" href="http://localhost/articles/my-first-article" />');
});

test('custom canonical urls are rendered', function () {
    Article::factory()->create([
        'slug' => 'my-first-article',
        'original_url' => 'https://joedixon.co.uk/my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    $this->get('/articles/my-first-article')
        ->see('<link rel="canonical" href="https://joedixon.co.uk/my-first-article" />');
});

test('draft articles cannot be viewed by guests', function () {
    Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => null]);

    $this->get('/articles/my-first-article')
        ->assertResponseStatus(404);
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
        ->assertResponseStatus(200)
        ->see('Draft');
});

test('draft articles cannot be viewed by logged in users', function () {
    Article::factory()->create([
        'slug' => 'my-first-article',
        'submitted_at' => null,
    ]);

    $this->login();

    $this->get('/articles/my-first-article')
        ->assertResponseStatus(404);
});

test('a user can view their articles', function () {
    $user = $this->createUser();

    $articles = Article::factory()->count(3)->create([
        'author_id' => $user->id,
    ]);

    $this->loginAs($user);

    $this->visit('/articles/authored')
        ->see($articles[0]->title())
        ->see($articles[1]->title())
        ->see($articles[2]->title());
});

test('a user can another users articles', function () {
    $articles = Article::factory()->count(3)->create();

    $this->login();

    $this->visit('/articles/authored')
        ->dontSee($articles[0]->title())
        ->dontSee($articles[1]->title())
        ->dontSee($articles[2]->title());
});

test('a guest cannot see articles', function () {
    $this->visit('/articles/authored')
        ->seePageIs('/login');
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
        ->dontSee('Test Tag');
});

test('share image url is rendered correctly', function () {
    Article::factory()->create([
        'slug' => 'my-first-article',
        'submitted_at' => now(),
        'approved_at' => now(),
    ]);

    $this->get('/articles/my-first-article')
        ->see('articles/my-first-article/social.png')
        ->dontSee('images/laravelio-share.png');
});

test('default share image is used on non article pages', function () {
    $this->get('/')
        ->see('images/laravelio-share.png')
        ->dontSee('articles/my-first-article/social.png');
});

test('user see a tip if they have not set the twitter handle', function () {
    $this->login(['twitter' => null]);

    $this->get('/articles/authored')
        ->seeLink('Twitter handle')
        ->see('so we can link to your profile when we tweet out your article.');
});

test('user do not see tip if they have set the twitter handle', function () {
    $this->login();

    $this->get('/articles/authored')
        ->dontSeeLink('Twitter handle')
        ->dontSee('so we can link to your profile when we tweet out your article.');
});

test('loading page with invalid sort parameter defaults to recent', function () {
    Article::factory()->create(['slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now()]);

    $this->get('/articles?filter=invalid')
        ->see('<link rel="canonical" href="http://localhost/articles?filter=recent" />');
});

test('can filter articles by tag', function () {
    $articleOne = Article::factory()->create(['title' => 'My First Article', 'slug' => 'my-first-article', 'submitted_at' => now(), 'approved_at' => now()]);
    $tagOne = Tag::factory()->create(['slug' => 'one']);
    $articleOne->syncTags([$tagOne->id]);

    $articleTwo = Article::factory()->create(['title' => 'My Second Article', 'slug' => 'my-second-article', 'submitted_at' => now(), 'approved_at' => now()]);
    $tagTwo = Tag::factory()->create(['slug' => 'two']);
    $articleTwo->syncTags([$tagTwo->id]);

    $this->get('/articles?tag=one')
        ->see('My First Article')
        ->dontSee('My Second Article');
});
