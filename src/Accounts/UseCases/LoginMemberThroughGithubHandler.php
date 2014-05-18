<?php namespace Lio\Accounts\UseCases; 

use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Guard;
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
     * @var \Illuminate\Auth\Guard
     */
    private $auth;
    /**
     * @var \Lio\Events\Dispatcher
     */
    private $dispatcher;

    public function __construct(Guard $auth, MemberRepository $memberRepository, Dispatcher $dispatcher)
    {
        $this->memberRepository = $memberRepository;
        $this->auth = $auth;
        $this->dispatcher = $dispatcher;
    }

    public function handle($request)
    {
        $member = $this->memberRepository->getByGithubId($request->githubId);

        if ( ! $member) {
            throw new MemberNotFoundException;
        }

        $member->loginThroughGithub($request->githubUser);
        $this->auth->login($member);

        $this->dispatcher->dispatch($member->releaseEvents());
    }
}
