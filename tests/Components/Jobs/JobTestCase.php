<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;

abstract class JobTestCase extends TestCase
{
    protected function dispatch($job)
    {
        return $job->handle();
    }
}
