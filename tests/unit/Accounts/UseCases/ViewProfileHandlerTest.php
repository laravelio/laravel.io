<?php namespace Lio\Accounts\UseCases;

use App;
use Lio\Accounts\Member;
use Mockery as m;

class ViewProfileHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Accounts\UseCases\ViewProfileHandler', $this->getHandler());
    }

    public function test_can_get_response()
    {
        $memberRepository = m::mock('Lio\Accounts\MemberRepository');
        $memberRepository->shouldReceive('getByName')->andReturn(new Member);

        $threadRepository = m::mock('Lio\Forum\ThreadRepository');
        $threadRepository->shouldIgnoreMissing();

        $replyRepository = m::mock('Lio\Forum\ReplyRepository');
        $replyRepository->shouldIgnoreMissing();

        $request = new ViewProfileRequest('foo');

        $response = $this->getHandler($memberRepository, $threadRepository, $replyRepository)->handle($request);

        $this->assertInstanceOf('Lio\Accounts\UseCases\ViewProfileResponse', $response);
    }

    private function getHandler($memberRepository = null, $threadRepository = null, $replyRepository = null)
    {
        return new ViewProfileHandler(
            $memberRepository ?: m::mock('Lio\Accounts\MemberRepository'),
            $threadRepository ?: m::mock('Lio\Forum\ThreadRepository'),
            $replyRepository ?: m::mock('Lio\Forum\ReplyRepository'));
    }
} 
