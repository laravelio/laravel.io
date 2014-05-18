<?php namespace Lio\Accounts\Commands;

use Lio\Accounts\Member;

class BanMemberCommand
{
    /**
     * @var \Lio\Accounts\Member
     */
    public $member;
    /**
     * @var \Lio\Accounts\Member
     */
    public $admin;

    public function __construct(Member $member, Member $admin)
    {
        $this->member = $member;
        $this->admin = $admin;
    }
} 
