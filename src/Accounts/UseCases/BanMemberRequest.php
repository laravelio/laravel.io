<?php namespace Lio\Accounts\UseCases; 

use Lio\Accounts\Member;

class BanMemberRequest
{
    /**
     * @var \Lio\Accounts\Member
     */
    private $problemMember;
    /**
     * @var \Lio\Accounts\Member
     */
    private $moderator;

    public function __construct(Member $problemMember, Member $moderator)
    {
        $this->problemMember = $problemMember;
        $this->moderator = $moderator;
    }
} 
