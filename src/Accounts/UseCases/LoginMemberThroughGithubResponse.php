<?php namespace Lio\Accounts\UseCases; 

use Lio\Accounts\Member;

class LoginMemberThroughGithubResponse
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
