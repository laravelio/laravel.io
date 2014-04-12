<?php namespace Lio\Accounts\Commands;

use Lio\Github\GithubUser;

class CreateUserFromGithubCommand
{
    /**
     * @var \Lio\Github\GithubUser
     */
    public $githubUser;

    public function __construct(GithubUser $githubUser)
    {
        $this->githubUser = $githubUser;
    }
} 
