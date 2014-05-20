<?php namespace Lio\Bin\UseCases; 

use Lio\Accounts\Member;

class CreatePasteRequest
{
    private $author;
    private $code;

    public function __construct($author, $code)
    {
        $this->author = $author;
        $this->code = $code;
    }
} 
