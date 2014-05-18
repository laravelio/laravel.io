<?php namespace Lio\Accounts\UseCases; 

class ViewProfileRequest
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
} 
