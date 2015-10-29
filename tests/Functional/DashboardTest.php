<?php
namespace Lio\Tests\Functional;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Testing\RequiresLogin;
use Lio\Tests\TestCase;

class DashboardTest extends TestCase
{
    use DatabaseMigrations, RequiresLogin;

    /**
     * @var string
     */
    protected $uri = '/dashboard';
}
