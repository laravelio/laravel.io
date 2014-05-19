<?php namespace Lio\Accounts\UseCases;

use App;
use Mockery as m;

class BanMemberHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Accounts\UseCases\BanMemberHandler', $this->getHandler());
    }

    public function test_unknown_members_throw_exceptions()
    {
        $this->setExpectedException('Lio\Accounts\MemberNotFoundException');

        $memberRepository = m::mock('Lio\Accounts\MemberRepository');
        $memberRepository->shouldReceive('getById')->andReturn(null);

        $handler = $this->getHandler($memberRepository);

        $request = new BanMemberRequest('foo', 'bar');
        $handler->handle($request);
    }

    private function getHandler($memberRepository = null, $dispatcher = null)
    {
        return new BanMemberHandler(
            $memberRepository ?: App::make('Lio\Accounts\MemberRepository'),
            $dispatcher ?: App::make('Lio\Events\Dispatcher'));
    }
} 
