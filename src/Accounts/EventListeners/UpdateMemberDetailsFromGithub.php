<?php namespace Lio\Accounts\EventListeners; 

use Lio\Accounts\MemberRepository;
use Lio\Events\Event;
use Lio\Events\Listener;

class UpdateMemberDetailsFromGithub implements Listener
{
    /**
     * @var \Lio\Accounts\MemberRepository
     */
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function handle(Event $event)
    {
        $member = $event->member;
        $github = $event->githubUser;

        $member->edit
        $member->name = $github->name;
        $member->email = $github->email;
        $member->github_url = $github->githubUrl;
        $member->github_id = $github->githubId;
        $member->image_url = $github->imageUrl;

        $this->memberRepository->save($member);
    }
}
