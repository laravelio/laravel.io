<?php

namespace App\Jobs;

use App\Models\Series;

final class DeleteSeries
{
    private $series;

    public function __construct(Series $series)
    {
        $this->series = $series;
    }

    public function handle()
    {
        $this->series->delete();
    }
}
