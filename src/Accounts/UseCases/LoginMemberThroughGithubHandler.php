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
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    public function __construct(AuthManager $auth, MemberRepository $memberRepository, Dispatcher $dispatcher)
    {
        $this->memberRepository = $memberRepository;
        $this->dispatcher = $dispatcher;
        $this->auth = $auth;
    }

    public function handle($request)
    {
        $githubUser = $request->githubUser;

        $member = $this->memberRepository->getByGithubId($githubUser->githubId);

        if ( ! $member) {
            throw new MemberNotFoundException;
        }

        $member->loginThroughGithub($githubUser->githubUser);
        $this->auth->login($member);

        $this->dispatcher->dispatch($member->releaseEvents());
    }
}
