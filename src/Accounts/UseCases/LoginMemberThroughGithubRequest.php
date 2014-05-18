<?php namespace Lio\Accounts\UseCases; 

use Lio\Github\GithubUser;

class LoginMemberThroughGithubRequest
{
    public $githubUser;

    public function __construct(GithubUser $githubUser)
    {
        $this->githubUser = $githubUser;
    }
} 
