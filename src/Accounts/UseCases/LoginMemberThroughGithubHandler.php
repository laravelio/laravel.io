<?php namespace Lio\Accounts\UseCases; 

use Illuminate\Auth\AuthManager;
use Lio\Accounts\MemberNotFoundException;
use Lio\Accounts\MemberRepository;
use Lio\CommandBus\Handler;
use Lio\Events\Dispatcher;

class LoginMemberThroughGithubHandler implements Handler
{
    /**
     * @var \Lio\Accounts\MemberRepository
     */
    private $memberRepository;
    /**
     * @var \Lio\Events\Dispatcher
     */
    private $dispatcher;

    public function __construct(MemberRepository $memberRepository, Dispatcher $dispatcher)
    {
        $this->memberRepository = $memberRepository;
        $this->dispatcher = $dispatcher;
    }

    public function handle($request)
    {
        $githubUser = $request->githubUser;

        $member = $this->memberRepository->getByGithubId($githubUser->githubId);

        if ( ! $member) {
            throw new MemberNotFoundException;
        }

        $member->name = $githubUser->name;
        $member->email = $githubUser->email;
        $member->github_url = $githubUser->githubUrl;
        $member->github_id = $githubUser->githubId;
        $member->image_url = $githubUser->imageUrl;

        $this->memberRepository->save($member);
        return $member;
    }
}
