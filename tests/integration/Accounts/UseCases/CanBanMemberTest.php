<?php namespace Lio\Accounts\UseCases;

use App;

class CanBanMemberTest extends \IntTestCase
{
    public function test_unknown_members_throw_exceptions()
    {
        $this->setExpectedException('Lio\Accounts\MemberNotFoundException');

        $request = new BanMemberRequest(999999, 999998);

        $this->getHandler()->handle($request);
    }

    private function getHandler()
    {
        return new BanMemberHandler(
            App::make('Lio\Accounts\MemberRepository'),
            App::make('Lio\Events\Dispatcher'));
    }
}
