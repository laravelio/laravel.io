<?php

namespace Tests\Feature;

use Tests\CreatesUsers;
use Tests\HttpAssertions;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication;
    use CreatesUsers;
    use HttpAssertions;

    public $baseUrl = 'http://localhost';

    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[WithFaker::class])) {
            $this->setUpFaker();
        }

        return $uses;
    }

    protected function dispatch($job)
    {
        return $job->handle();
    }
}
