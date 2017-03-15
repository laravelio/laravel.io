<?php

namespace Tests;

use App\Helpers\BuildsModels;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTestCase extends BaseTestCase
{
    use BuildsModels, CreatesApplication, CreatesUsers, HttpAssertions;

    public $baseUrl = 'http://localhost';
}
