<?php  namespace Lio\Bin\Commands;

use Lio\Accounts\Member;
use Lio\Bin\Paste;

class CreateForkCommand
{
    public $code;
    public $author;
    public $parent;

    public function __construct($code, $author, Paste $parent)
    {
        $this->code = $code;
        $this->author = $author;
        $this->parent = $parent;
    }
} 
