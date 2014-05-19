<?php namespace Lio\Accounts\UseCases; 

class ViewProfileRequest
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
} 
