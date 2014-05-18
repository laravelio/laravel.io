<?php namespace Lio\Accounts\Events; 

use Lio\Accounts\Member;
use Lio\Github\GithubUser;

class MemberLoggedInThroughGithub
{
    /**
     * @var \Lio\Accounts\Member
     */
    private $member;
    /**
     * @var \Lio\Github\GithubUser
     */
    private $githubUser;

    public function __construct(Member $member, GithubUser $githubUser)
    {
        $this->member = $member;
        $this->githubUser = $githubUser;
    }
} 
