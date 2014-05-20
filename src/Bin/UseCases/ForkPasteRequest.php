<?php namespace Lio\Bin\UseCases; 

use Lio\Accounts\Member;

class ForkPasteRequest
{
    private $hash;
    /**
     * @var \Lio\Accounts\Member
     */
    private $author;
    private $code;

    public function __construct($hash, Member $author, $code)
    {
        $this->hash = $hash;
        $this->author = $author;
        $this->code = $code;
    }
} 
