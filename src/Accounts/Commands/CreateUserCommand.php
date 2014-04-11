<?php namespace Lio\Accounts\Commands; 

class CreateUserCommand
{
    public $email;
    public $name;
    public $githubUrl;
    public $githubId;
    public $imageUrl;

    public function __construct($email, $name, $githubUrl, $githubId, $imageUrl)
    {
        $this->email = $email;
        $this->name = $name;
        $this->githubUrl = $githubUrl;
        $this->githubId = $githubId;
        $this->imageUrl = $imageUrl;
    }
} 
