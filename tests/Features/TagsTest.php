<?php

namespace Tests\Features;

use App\Forum\ThreadRepository;
use App\Forum\Topic;
use App\Tags\Tag;
use App\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_see_a_list_of_tags()
    {
        $this->create(Tag::class, ['name' => 'Eloquent', 'description' => 'Example description.']);

        $this->visit('/tags')
            ->see('Eloquent')
            ->see('Example description.');
    }

    /** @test */
    public function users_can_see_content_related_to_a_tag()
    {
        $topic = $this->create(Topic::class);
        $tag = $this->create(Tag::class, ['name' => 'Eloquent', 'description' => 'Example description.']);

        $this->app->make(ThreadRepository::class)->create(
            $this->create(User::class),
            $topic,
            'Foo Thread',
            'Foo Thread Body',
            ['tags' => [$tag->id()]]
        );

        $this->visit('/tags/'.$tag->slug())
            ->see('Eloquent')
            ->see('Example description.')
            ->see('Foo Thread');
    }
}
