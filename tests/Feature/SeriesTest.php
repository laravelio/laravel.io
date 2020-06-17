<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Series;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SeriesTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_view_their_series()
    {
        $user = $this->createUser();
        factory(Series::class)->create([
            'author_id' => $user->id(),
            'title' => 'My first series',
            'slug' => 'my-first-series',
        ]);

        $this->loginAs($user);

        $this->visit('/series/authored')
            ->see('My first series');
    }

    /** @test */
    public function users_cannot_view_the_series_of_other_users()
    {
        $user = $this->createUser();
        factory(Series::class)->create([
            'title' => 'Another users series',
            'slug' => 'another-users-series',
        ]);

        $this->loginAs($user);

        $this->visit('/series/authored')
            ->dontSee('Another users series');
    }

    /** @test */
    public function users_can_see_how_many_articles_in_a_series()
    {
        $user = $this->createUser();
        $series = factory(Series::class)->create([
            'author_id' => $user->id(),
            'title' => 'My first series',
            'slug' => 'my-first-series',
        ]);
        factory(Article::class, 2)->create([
            'author_id' => $user->id(),
            'series_id' => $series->id(),
        ]);

        $this->loginAs($user);

        $this->visit('/series/authored')
            ->see('2 articles in series');
    }

    /** @test */
    public function users_cannot_create_a_series_when_not_logged_in()
    {
        $this->visit('/series/create')
            ->seePageIs('/login');
    }

    /** @test */
    public function users_can_create_a_series()
    {
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

        $this->login();

        $this->post('/series', [
            'title' => 'A developers guide to SVG',
            'tags' => [$tag->id()],
        ])
            ->assertRedirectedTo('/series/authored')
            ->assertSessionHas('success', 'Series successfully created!');
    }

    /** @test */
    public function users_cannot_create_a_series_with_a_title_that_is_too_long()
    {
        $this->login();

        $response = $this->post('/series', [
            'title' => 'A developers guide to SVG which is an image format written in XML which is highly customisable and flexible',
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['title' => 'The title may not be greater than 100 characters.']);
    }

    /** @test */
    public function users_can_edit_a_series()
    {
        $user = $this->createUser();
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        factory(Series::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-series',
        ]);

        $this->loginAs($user);

        $this->put('/series/my-first-series', [
            'title' => 'A developers guide to SVG',
            'tags' => [$tag->id()],
        ])
            ->assertRedirectedTo('/series/authored')
            ->assertSessionHas('success', 'Series successfully updated!');
    }

    /** @test */
    public function users_cannot_edit_a_series_with_a_title_that_is_too_long()
    {
        $user = $this->createUser();
        factory(Series::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-series',
        ]);

        $this->loginAs($user);

        $response = $this->put('/series/my-first-series', [
            'title' => 'A developers guide to SVG which is an image format written in XML which is highly customisable and flexible',
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['title' => 'The title may not be greater than 100 characters.']);
    }

    /** @test */
    public function users_can_delete_their_own_series()
    {
        $user = $this->createUser();
        factory(Series::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-series',
        ]);

        $this->loginAs($user);

        $this->delete('/series/my-first-series')
            ->assertRedirectedTo('/series/authored')
            ->assertSessionHas('success', 'Series successfully deleted!');
    }

    /** @test */
    public function users_cannot_delete_a_series_they_do_not_own()
    {
        factory(Series::class)->create(['slug' => 'my-first-thread']);

        $this->login();

        $this->delete('/series/my-first-thread')
            ->assertForbidden();
    }
}
