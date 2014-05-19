<?php namespace Lio\Accounts\UseCases;

use App;
use Lio\Accounts\Member;
use Lio\Github\GithubUser;
use Mockery as m;

class LoginMemberThroughGithubHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Accounts\UseCases\LoginMemberThroughGithubHandler', $this->getHandler());
    }

    public function test_unknown_member_throws_exception()
    {
        $this->setExpectedException('Lio\Accounts\MemberNotFoundException');

        $memberRepository = m::mock('Lio\Accounts\MemberRepository');
        $memberRepository->shouldReceive('getByGithubId')->andReturn(null);

        $handler = $this->getHandler($memberRepository);

        $request = new LoginMemberThroughGithubRequest(new GithubUser(
            'foo-name', 'bar-email', 'baz-url', 'caz-id', 'shaz-imageurl'
        ));

        $handler->handle($request);
    }

    public function test_member_details_are_updated_at_login()
    {
        $member = new Member;

        $memberRepository = m::mock('Lio\Accounts\MemberRepository');
        $memberRepository->shouldReceive('getByGithubId')->andReturn($member);
        $memberRepository->shouldIgnoreMissing();

        $handler = $this->getHandler($memberRepository);

        $request = new LoginMemberThroughGithubRequest(new GithubUser(
            'name', 'email', 'url', 'id', 'imageurl'
        ));

        $handler->handle($request);

        $this->assertEquals([
            'name' => 'name',
            'email' => 'email',
            'github_url' => 'url',
            'github_id' => 'id',
            'image_url' => 'imageurl',
        ], $member->getAttributes());
    }

    private function getHandler($memberRepository = null, $dispatcher = null)
    {
        return new LoginMemberThroughGithubHandler(
            $memberRepository ?: App::make('Lio\Accounts\MemberRepository'),
            $dispatcher ?: App::make('Lio\Events\Dispatcher'));
    }
}
