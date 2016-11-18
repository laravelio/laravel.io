<?php

namespace Tests\Features;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\RequiresLogin;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use DatabaseMigrations, RequiresLogin;

    /**
     * @var string
     */
    protected $uri = '/dashboard';
}
