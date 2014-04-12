<?php namespace Lio\Github; 

class GithubUser
{
    public $name;
    public $email;
    public $githubUrl;
    public $githubId;
    public $imageUrl;

    public function __construct($name, $email, $githubUrl, $githubId, $imageUrl)
    {
        $this->name = $name;
        $this->email = $email;
        $this->githubUrl = $githubUrl;
        $this->githubId = $githubId;
        $this->imageUrl = $imageUrl;
    }
} 
