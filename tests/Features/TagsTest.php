<?php

namespace Tests\Features;

use App\Models\Thread;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

class TagsTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_see_a_list_of_tags()
    {
        factory(Tag::class)->create(['name' => 'Eloquent', 'description' => 'Example description.']);

        $this->visit('/tags')
            ->see('Eloquent')
            ->see('Example description.');
    }

    /** @test */
    public function users_can_see_content_related_to_a_tag()
    {
        $thread = factory(Thread::class)->create(['subject' => 'Foo Thread']);
        $tag = factory(Tag::class)->create(['name' => 'Eloquent', 'description' => 'Example description.']);
        $thread->tagsRelation()->sync([$tag->id()]);

        $this->visit('/tags/'.$tag->slug())
            ->see('Eloquent')
            ->see('Example description.')
            ->see('Foo Thread');
    }
}
