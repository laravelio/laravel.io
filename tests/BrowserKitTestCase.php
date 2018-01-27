<?php

namespace Tests;

use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication, CreatesUsers, FakesData, HttpAssertions;

    public $baseUrl = 'http://localhost';

    protected function dispatch($job)
    {
        return $job->handle();
    }
}
