<?php namespace Lio\Accounts\UseCases; 

use Lio\Accounts\MemberRepository;
use Lio\CommandBus\Handler;
use Lio\Core\Exceptions\EntityNotFoundException;
use Lio\Events\Dispatcher;

class BanMemberHandler implements Handler
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

    public function handle($command)
    {
        $problemMember = $this->memberRepository->getById($command->problemMemberId);
        $moderator = $this->memberRepository->getById($command->moderatorId);

        if ( ! $problemMember || ! $moderator) {
            throw new EntityNotFoundException;
        }

        $problemMember->bannedBy($moderator);
        $this->memberRepository->save($problemMember);
        $this->dispatcher->dispatch($problemMember->releaseEvents());
    }
}
