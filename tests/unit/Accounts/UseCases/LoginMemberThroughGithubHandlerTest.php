<?php namespace Lio\Accounts\UseCases;

use App;
use Lio\Github\GithubUser;
use Mockery as m;

class LoginMemberThroughGithubHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Accounts\UseCases\LoginMemberThroughGithubHandler', $this->getHandler());
    }

    public function test_unknown_members_throw_exceptions()
    {
        $this->setExpectedException('Lio\Accounts\MemberNotFoundException');

        $memberRepository = m::mock('Lio\Accounts\MemberRepository');
        $memberRepository->shouldReceive('getByGithubId')->andReturn(null);

        $handler = $this->getHandler(null, $memberRepository);

        $request = new LoginMemberThroughGithubRequest(new GithubUser(
            'foo-name', 'bar-email', 'baz-url', 'caz-id', 'shaz-imageurl'
        ));

        $handler->handle($request);
    }

    private function getHandler($auth = null, $memberRepository = null, $dispatcher = null)
    {
        return new LoginMemberThroughGithubHandler(
            $auth ?: App::make('auth'),
            $memberRepository ?: App::make('Lio\Accounts\MemberRepository'),
            $dispatcher ?: App::make('Lio\Events\Dispatcher'));
    }
}
