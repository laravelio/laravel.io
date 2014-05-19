<?php namespace Lio\Accounts\UseCases;

use App;

class CanBanMemberTest extends \IntTestCase
{
    private function getHandler()
    {
        return new BanMemberHandler(
            App::make('Lio\Accounts\MemberRepository'),
            App::make('Lio\Events\Dispatcher'));
    }
}
