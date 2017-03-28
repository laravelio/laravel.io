<?php

namespace Tests;

use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication, CreatesUsers, HttpAssertions;

    public $baseUrl = 'http://localhost';
}
