<?php

namespace Tests\Integration\Jobs;

use App\Jobs\DeleteSeries;
use App\Models\Series;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteSeriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_series_can_be_deleted()
    {
        $series = Series::factory()->create();

        $this->dispatch(new DeleteSeries($series));

        $this->assertDatabaseMissing('series', ['id' => $series->id()]);
    }
}
