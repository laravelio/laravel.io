<?php

namespace Lio\Tests\Functional\Forum;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Tests\TestCase;

class OverviewTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_the_create_thread_button()
    {
        $this->visit('/forum')
            ->see('Create Thread');
    }
}
