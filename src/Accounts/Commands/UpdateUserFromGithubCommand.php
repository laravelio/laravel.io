<?php namespace Lio\Accounts\Commands;

use Lio\Accounts\User;
use Lio\Github\GithubUser;

class UpdateUserFromGithubCommand
{
    /**
     * @var \Lio\Accounts\User
     */
    public $user;
    /**
     * @var \Lio\Github\GithubUser
     */
    public $githubUser;

    public function __construct(User $user, GithubUser $githubUser)
    {
        $this->user = $user;
        $this->githubUser = $githubUser;
    }
} 
