<?php

use Lio\Accounts\UseCases\LoginMemberThroughGithubHandler;
use Lio\Accounts\UseCases\LoginMemberThroughGithubRequest;
use Lio\Github\GithubUser;

class LoginMemberThroughGithubHandlerTest extends UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Accounts\UseCases\LoginMemberThroughGithubHandler', $this->getHandler());
    }

    public function test_unknown_members_throw_exceptions()
    {
        $this->setExpectedException('Lio\Accounts\MemberNotFoundException');

        $request = new LoginMemberThroughGithubRequest(new GithubUser(
            'foo-name', 'bar-email', 'baz-url', 'caz-id', 'shaz-imageurl'
        ));

        $this->getHandler()->handle($request);
    }

    private function getHandler()
    {
        return new LoginMemberThroughGithubHandler(
            App::make('auth'),
            App::make('Lio\Accounts\MemberRepository'),
            App::make('Lio\Events\Dispatcher'));
    }
}
