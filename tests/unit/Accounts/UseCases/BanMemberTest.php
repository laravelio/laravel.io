<?php

use Lio\Accounts\UseCases\BanMemberRequest;

class BanMemberTest extends UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Accounts\UseCases\BanMemberHandler', $this->getHandler());
    }

    public function test_unknown_members_throw_exceptions()
    {
        $this->setExpectedException('Lio\Accounts\MemberNotFoundException');

        $request = new BanMemberRequest(999999, 999998);

        $this->getHandler()->handle($request);
    }

    private function getHandler()
    {
        return new \Lio\Accounts\UseCases\BanMemberHandler(
            App::make('Lio\Accounts\MemberRepository'),
            App::make('Lio\Events\Dispatcher'));
    }
} 
