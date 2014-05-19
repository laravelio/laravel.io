<?php namespace Lio\Accounts\UseCases; 

use Lio\Accounts\MemberNotFoundException;
use Lio\Accounts\MemberRepository;
use Lio\CommandBus\Handler;
use Lio\Forum\ReplyRepository;
use Lio\Forum\ThreadRepository;

class ViewProfileHandler implements Handler
{
    /**
     * @var \Lio\Accounts\MemberRepository
     */
    private $memberRepository;
    /**
     * @var \Lio\Forum\ThreadRepository
     */
    private $threadRepository;
    /**
     * @var \Lio\Forum\ReplyRepository
     */
    private $replyRepository;

    public function __construct(MemberRepository $memberRepository, ThreadRepository $threadRepository, ReplyRepository $replyRepository)
    {
        $this->memberRepository = $memberRepository;
        $this->threadRepository = $threadRepository;
        $this->replyRepository = $replyRepository;
    }

    public function handle($request)
    {
        $member = $this->memberRepository->getByName($request->name);

        if ( ! $member) {
            throw new MemberNotFoundException;
        }

        $threads = $this->threadRepository->getRecentByMember($member, 5);
        $replies = $this->replyRepository->getRecentByMember($member, 5);

        return new ViewProfileResponse($member, $threads, $replies);
    }
}
