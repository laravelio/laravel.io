<?php namespace Lio\Bin\UseCases; 

class ViewPasteRequest
{
    private $hash;

    public function __construct($hash)
    {
        $this->hash = $hash;
    }
} 
