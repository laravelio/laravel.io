<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Series;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArticleTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_cannot_create_an_article_when_not_logged_in()
    {
        $this->visit('/articles/create')
            ->seePageIs('/login');
    }

    /** @test */
    public function users_cannot_see_series_they_do_not_own_when_creating_an_article()
    {
        $user = $this->createUser();
        factory(Series::class)->create(['title' => 'This should be seen', 'author_id' => $user->id]);
        factory(Series::class)->create(['title' => 'This should not be seen']);

        $this->loginAs($user);

        $this->get('/articles/create')
            ->see('This should be seen')
            ->dontSee('This should not be seen');
    }

    /** @test */
    public function users_can_create_an_article()
    {
        $user = $this->createUser();
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        $series = factory(Series::class)->create([
            'title' => 'Test series',
            'author_id' => $user->id,
        ]);

        $this->loginAs($user);

        $this->post('/articles', [
            'title' => 'Using database migrations',
            'body' => 'This article will go into depth on working with database migrations.',
            'tags' => [$tag->id()],
            'series' => $series->id(),
            'status' => 'draft',
        ])
            ->assertRedirectedTo('/articles/using-database-migrations')
            ->assertSessionHas('success', 'Article successfully created!');
    }

    /** @test */
    public function users_can_publish_an_article()
    {
        $this->login();

        $this->post('/articles', [
            'title' => 'Using database migrations',
            'body' => 'This article will go into depth on working with database migrations.',
            'status' => 'publish',
        ])
            ->assertRedirectedTo('/articles/using-database-migrations')
            ->followRedirects()
            ->dontSee('Draft');
    }

    /** @test */
    public function users_can_create_a_draft_article()
    {
        $this->login();

        $this->post('/articles', [
            'title' => 'Using database migrations',
            'body' => 'This article will go into depth on working with database migrations.',
            'status' => 'draft',
        ])
            ->assertRedirectedTo('/articles/using-database-migrations')
            ->followRedirects()
            ->see('Draft');
    }

    /** @test */
    public function users_cannot_create_an_article_using_a_series_they_do_not_own()
    {
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        $series = factory(Series::class)->create(['title' => 'Test series']);

        $this->login();

        $response = $this->post('/articles', [
            'title' => 'Using database migrations',
            'body' => 'This article will go into depth on working with database migrations.',
            'tags' => [$tag->id()],
            'series' => $series->id(),
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['series' => 'The selected series does not belong to you.']);
    }

    /** @test */
    public function users_cannot_create_an_article_with_a_title_that_is_too_long()
    {
        $this->login();

        $response = $this->post('/articles', [
            'title' => 'Adding Notifications to make a really engaging UI for Laravel.io users using Livewire, Alpine.js and Tailwind UI',
            'body' => 'The title of this article is too long',
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['title' => 'The title may not be greater than 100 characters.']);
    }

    /** @test */
    public function an_article_may_not_contain_an_http_image_url()
    {
        $this->login();

        $response = $this->post('/articles', [
            'body' => 'This is a really interesting article about images. Here is ![an image](http://example.com/image.jpg).',
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['body' => 'The body field contains at least one image with an HTTP link.']);
    }

    /** @test */
    public function users_cannot_see_series_they_do_not_own_when_editing_an_article()
    {
        $user = $this->createUser();
        factory(Article::class)->create(['slug' => 'my-first-article', 'author_id' => $user->id]);
        factory(Series::class)->create(['title' => 'This should be seen', 'author_id' => $user->id]);
        factory(Series::class)->create(['title' => 'This should not be seen']);

        $this->loginAs($user);

        $this->get('/articles/my-first-article/edit')
            ->see('This should be seen')
            ->dontSee('This should not be seen');
    }

    /** @test */
    public function users_can_edit_an_article()
    {
        $user = $this->createUser();
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        $series = factory(Series::class)->create([
            'title' => 'Test series',
            'author_id' => $user->id,
        ]);

        factory(Article::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-article',
        ]);

        $this->loginAs($user);

        $this->put('/articles/my-first-article', [
            'title' => 'Using database migrations',
            'body' => 'This article will go into depth on working with database migrations.',
            'tags' => [$tag->id()],
            'series' => $series->id(),
            'status' => 'publish',
        ])
            ->assertRedirectedTo('/articles/using-database-migrations')
            ->assertSessionHas('success', 'Article successfully updated!');
    }

    /** @test */
    public function users_can_publish_an_existing_article()
    {
        $user = $this->createUser();

        factory(Article::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-article',
            'published_at' => null,
        ]);

        $this->loginAs($user);

        $this->put('/articles/my-first-article', [
            'title' => 'Using database migrations',
            'body' => 'This article will go into depth on working with database migrations.',
            'status' => 'publish',
        ])
            ->assertRedirectedTo('/articles/using-database-migrations')
            ->followRedirects()
            ->dontSee('Draft');
    }

    /** @test */
    public function users_can_unpublish_an_existing_article()
    {
        $user = $this->createUser();

        factory(Article::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-article',
            'published_at' => now(),
        ]);

        $this->loginAs($user);

        $this->put('/articles/my-first-article', [
            'title' => 'Using database migrations',
            'body' => 'This article will go into depth on working with database migrations.',
            'status' => 'draft',
        ])
            ->assertRedirectedTo('/articles/using-database-migrations')
            ->followRedirects()
            ->see('Draft');
    }

    /** @test */
    public function users_cannot_edit_an_article_using_a_series_they_do_not_own()
    {
        $user = $this->createUser();
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        $series = factory(Series::class)->create(['title' => 'Test series']);

        factory(Article::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-article',
        ]);

        $this->loginAs($user);

        $response = $this->put('/articles/my-first-article', [
            'title' => 'Using database migrations',
            'body' => 'This article will go into depth on working with database migrations.',
            'tags' => [$tag->id()],
            'series' => $series->id(),
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['series' => 'The selected series does not belong to you.']);
    }

    /** @test */
    public function users_cannot_edit_an_article_with_a_title_that_is_too_long()
    {
        $user = $this->createUser();
        factory(Article::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-article',
        ]);

        $this->loginAs($user);

        $response = $this->put('/articles/my-first-article', [
            'title' => 'Adding Notifications to make a really engaging UI for Laravel.io users using Livewire, Alpine.js and Tailwind UI',
            'body' => 'The title of this article is too long',
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['title' => 'The title may not be greater than 100 characters.']);
    }

    /** @test */
    public function an_article_may_not_updated_to_contain_an_http_image_url()
    {
        $user = $this->createUser();
        factory(Article::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-article',
        ]);

        $this->loginAs($user);

        $response = $this->put('/articles/my-first-article', [
            'body' => 'This is a really interesting article about images. Here is ![an image](http://example.com/image.jpg).',
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['body' => 'The body field contains at least one image with an HTTP link.']);
    }

    /** @test */
    public function users_can_delete_their_own_articles()
    {
        $user = $this->createUser();
        factory(Article::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-article',
        ]);

        $this->loginAs($user);

        $this->delete('/articles/my-first-article')
            ->assertRedirectedTo('/articles')
            ->assertSessionHas('success', 'Article successfully deleted!');
    }

    /** @test */
    public function users_cannot_delete_an_article_they_do_not_own()
    {
        factory(Article::class)->create(['slug' => 'my-first-article']);

        $this->login();

        $this->delete('/articles/my-first-article')
            ->assertForbidden();
    }

    /** @test */
    public function canonical_urls_are_rendered()
    {
        factory(Article::class)->create(['slug' => 'my-first-article', 'published_at' => now()]);

        $this->get('/articles/my-first-article')
            ->see('<link rel="canonical" href="http://localhost/articles/my-first-article" />');
    }

    /** @test */
    public function custom_canonical_urls_are_rendered()
    {
        factory(Article::class)->create(['slug' => 'my-first-article', 'original_url' => 'https://joedixon.co.uk/my-first-article', 'published_at' => now()]);

        $this->get('/articles/my-first-article')
            ->see('<link rel="canonical" href="https://joedixon.co.uk/my-first-article" />');
    }

    /** @test */
    public function draft_articles_cannot_be_viewed_by_guests()
    {
        factory(Article::class)->create(['slug' => 'my-first-article', 'published_at' => null]);

        $this->get('/articles/my-first-article')
            ->assertResponseStatus(404);
    }

    /** @test */
    public function draft_articles_can_be_viewed_by_the_article_owner()
    {
        $user = $this->createUser();
        factory(Article::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-article',
            'published_at' => null,
        ]);

        $this->loginAs($user);

        $this->get('/articles/my-first-article')
            ->assertResponseStatus(200)
            ->see('Draft');
    }

    /** @test */
    public function draft_articles_cannot_be_viewed_by_logged_in_users()
    {
        factory(Article::class)->create([
            'slug' => 'my-first-article',
            'published_at' => null,
        ]);

        $this->login();

        $this->get('/articles/my-first-article')
            ->assertResponseStatus(404);
    }
}
