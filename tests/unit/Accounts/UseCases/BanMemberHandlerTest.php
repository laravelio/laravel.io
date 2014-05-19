<?php namespace Lio\Accounts\UseCases;

use App;
use Mockery as m;

class BanMemberHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Accounts\UseCases\BanMemberHandler', $this->getHandler());
    }

    public function test_unknown_problem_member_throws_exception()
    {
        $this->setExpectedException('Lio\Accounts\MemberNotFoundException');

        $memberRepository = m::mock('Lio\Accounts\MemberRepository');
        $memberRepository->shouldReceive('getById')->andReturn(true, false);

        $handler = $this->getHandler($memberRepository);

        $request = new BanMemberRequest('foo', 'bar');
        $handler->handle($request);
    }

    public function test_unknown_moderator_throws_exception()
    {
        $this->setExpectedException('Lio\Accounts\MemberNotFoundException');

        $memberRepository = m::mock('Lio\Accounts\MemberRepository');
        $memberRepository->shouldReceive('getById')->andReturn(false, true);

        $handler = $this->getHandler($memberRepository);

        $request = new BanMemberRequest('foo', 'bar');
        $handler->handle($request);
    }

    private function getHandler($memberRepository = null, $dispatcher = null)
    {
        return new BanMemberHandler(
            $memberRepository ?: m::mock('Lio\Accounts\MemberRepository'),
            $dispatcher ?: App::make('Lio\Events\Dispatcher'));
    }
} 
