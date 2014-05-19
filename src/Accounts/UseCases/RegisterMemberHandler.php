<?php namespace Lio\Accounts\UseCases; 

use Lio\Accounts\Member;
use Lio\Accounts\MemberRepository;
use Lio\CommandBus\Handler;
use Lio\Events\Dispatcher;

class RegisterMemberHandler implements Handler
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
        $member = Member::register(
            $request->name,
            $request->email,
            $request->githubUrl,
            $request->githubId,
            $request->imageUrl
        );

        $this->memberRepository->save($member);
        $this->dispatcher->dispatch($member->releaseEvents());

        return new RegisterMemberResponse($member);
    }
}
