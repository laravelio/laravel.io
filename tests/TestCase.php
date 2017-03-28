<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;
use Hash;

abstract class TestCase extends IlluminateTestCase
{
    use CreatesApplication, CreatesUsers, HttpAssertions;
}
