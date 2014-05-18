<?php namespace Lio\Accounts\UseCases; 

class LoginMemberRequest
{
    private $githubId;

    public function __construct($githubId)
    {
        $this->githubId = $githubId;
    }
} 
