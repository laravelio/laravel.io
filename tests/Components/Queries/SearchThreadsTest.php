<?php

namespace Tests\Components\Queries;

use App\Models\Thread;
use App\Queries\SearchThreads;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SearchThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_search_by_name_or_body()
    {
        factory(Thread::class)->create(['subject' => 'Optimizing Eloquent']);
        factory(Thread::class)->create(['body' => 'What can we do to optimize the behavior or Eloquent?']);

        $this->assertCount(1, SearchThreads::get('optimizing'));
        $this->assertCount(1, SearchThreads::get('behavior'));
    }
}
