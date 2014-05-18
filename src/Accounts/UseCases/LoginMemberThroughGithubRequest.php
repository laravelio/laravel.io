<?php namespace Lio\Accounts\UseCases; 

use Lio\Github\GithubUser;

class LoginMemberThroughGithubRequest
{
    private $githubUser;

    public function __construct(GithubUser $githubUser)
    {
        $this->githubUser = $githubUser;
    }
} 
