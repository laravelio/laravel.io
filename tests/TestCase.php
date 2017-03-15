<?php

namespace Tests;

use App\Helpers\BuildsModels;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;
use Hash;

abstract class TestCase extends IlluminateTestCase
{
    use BuildsModels, CreatesApplication, CreatesUsers, HttpAssertions;
}
