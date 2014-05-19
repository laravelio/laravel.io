<?php namespace Lio\Accounts\UseCases;

use App;
use Mockery as m;

class RegisterMemberHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Accounts\UseCases\RegisterMemberHandler', $this->getHandler());
    }

    public function test_can_register_member()
    {
        $memberRepository = m::mock('Lio\Accounts\MemberRepository');
        $memberRepository->shouldIgnoreMissing();

        $request = new RegisterMemberRequest(
            'name', 'email', 'url', 'id', 'image'
        );

        $response = $this->getHandler($memberRepository)->handle($request);

        $this->assertInstanceOf('Lio\Accounts\UseCases\RegisterMemberResponse', $response);
    }

    private function getHandler($memberRepository = null, $dispatcher = null)
    {
        return new RegisterMemberHandler(
            $memberRepository ?: m::mock('Lio\Accounts\MemberRepository'),
            $dispatcher ?: App::make('Lio\Events\Dispatcher'));
    }
} 
