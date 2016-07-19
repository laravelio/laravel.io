<?php

namespace Lio\Tests\Functional;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Forum\ThreadRepository;
use Lio\Forum\Topics\Topic;
use Lio\Tags\Tag;
use Lio\Tests\TestCase;
use Lio\Users\User;

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
