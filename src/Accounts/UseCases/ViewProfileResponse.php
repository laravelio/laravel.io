<?php namespace Lio\Accounts\UseCases; 

use Lio\Accounts\Member;

class ViewProfileResponse
{
    /**
     * @var \Lio\Accounts\Member
     */
    public $member;
    public $threads;
    public $replies;

    public function __construct(Member $member, $threads, $replies)
    {
        $this->member = $member;
        $this->threads = $threads;
        $this->replies = $replies;
    }
}
