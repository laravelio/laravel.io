<?php

namespace Tests\Integration\Jobs;

use App\Jobs\CreateSeries;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateSeriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_series()
    {
        $user = $this->createUser();

        $series = $this->dispatch(new CreateSeries('Title', $user));

        $this->assertEquals('Title', $series->title());
    }
}
