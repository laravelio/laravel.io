<?php namespace Lio\Accounts\UseCases;

use App;

class BanMemberHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Accounts\UseCases\BanMemberHandler', $this->getHandler());
    }

    private function getHandler()
    {
        return new BanMemberHandler(
            App::make('Lio\Accounts\MemberRepository'),
            App::make('Lio\Events\Dispatcher'));
    }
} 
