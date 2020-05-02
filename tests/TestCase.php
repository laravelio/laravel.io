<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;

abstract class TestCase extends IlluminateTestCase
{
    use CreatesApplication;
    use CreatesUsers;
    use HttpAssertions;

    protected function dispatch($job)
    {
        return $job->handle();
    }
}
