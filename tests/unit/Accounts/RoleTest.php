<?php namespace Lio\Accounts;

class RoleTest extends \UnitTestCase
{
    public function test_can_create_role()
    {
        $this->assertInstanceOf('Lio\Accounts\Role', new Role);
    }
}
