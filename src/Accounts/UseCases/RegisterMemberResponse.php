<?php namespace Lio\Accounts\UseCases; 

use Lio\Accounts\Member;

class RegisterMemberResponse
{
    /**
     * @var \Lio\Accounts\Member
     */
    public $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}
