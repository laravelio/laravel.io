<?php

namespace Tests\Integration\Queries;

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
        Thread::factory()->create(['subject' => 'Optimizing Eloquent']);
        Thread::factory()->create(['body' => 'What can we do to optimize the behavior or Eloquent?']);

        $this->assertCount(1, SearchThreads::get('optimizing'));
        $this->assertCount(1, SearchThreads::get('behavior'));
    }
}
