<?php

namespace Tests\Features;

use App\Forum\Thread;
use App\Forum\ThreadData;
use App\Models\Topic;
use App\Models\Tag;
use App\User;
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
        $tag = factory(Tag::class)->create(['name' => 'Eloquent', 'description' => 'Example description.']);

        Thread::createFromData($this->ThreadData($tag));

        $this->visit('/tags/'.$tag->slug())
            ->see('Eloquent')
            ->see('Example description.')
            ->see('Foo Thread');
    }

    private function ThreadData(Tag $tag): ThreadData
    {
        return new class($tag) extends TagsTest implements ThreadData
        {
            public function __construct($tag)
            {
                $this->tag = $tag;
            }

            public function author(): User
            {
                return $this->createUser();
            }

            public function subject(): string
            {
                return 'Foo Thread';
            }

            public function body(): string
            {
                return 'Foo Thread Body';
            }

            public function topic(): Topic
            {
                return factory(Topic::class)->create();
            }

            public function ip()
            {
                return '';
            }

            public function tags(): array
            {
                return [$this->tag->id()];
            }
        };
    }
}
