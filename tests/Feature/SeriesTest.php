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
    public function users_cannot_create_a_series_when_not_logged_in()
    {
        $this->visit('/articles/series/create')
            ->seePageIs('/login');
    }

    /** @test */
    public function users_can_create_a_series()
    {
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

        $this->login();

        $this->post('/articles/series', [
            'title' => 'A developers guide to SVG',
            'tags' => [$tag->id()],
        ])
            ->assertRedirectedTo('/articles/series/1')
            ->assertSessionHas('success', 'Series successfully created!');
    }

    /** @test */
    public function users_cannot_create_a_series_with_a_title_that_is_too_long()
    {
        $this->login();

        $response = $this->post('/articles/series', [
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
        ]);

        $this->loginAs($user);

        $this->put('/articles/series/1', [
            'title' => 'A developers guide to SVG',
            'tags' => [$tag->id()],
        ])
            ->assertRedirectedTo('/articles/series/1')
            ->assertSessionHas('success', 'Series successfully updated!');
    }

    /** @test */
    public function users_cannot_edit_a_series_with_a_title_that_is_too_long()
    {
        $user = $this->createUser();
        factory(Series::class)->create([
            'author_id' => $user->id()
        ]);

        $this->loginAs($user);

        $response = $this->put('/articles/series/1', [
            'title' => 'A developers guide to SVG which is an image format written in XML which is highly customisable and flexible',
        ]);

        $response->assertSessionHas('error', 'Something went wrong. Please review the fields below.');
        $response->assertSessionHasErrors(['title' => 'The title may not be greater than 100 characters.']);
    }
}
