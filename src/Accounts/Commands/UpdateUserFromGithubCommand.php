<?php namespace Lio\Accounts\Commands;

use Lio\Accounts\Member;
use Lio\Github\GithubUser;

class UpdateUserFromGithubCommand
{
    /**
     * @var \Lio\Accounts\Member
     */
    public $user;
    /**
     * @var \Lio\Github\GithubUser
     */
    public $githubUser;

    public function __construct(Member $user, GithubUser $githubUser)
    {
        $this->user = $user;
        $this->githubUser = $githubUser;
    }
} 
