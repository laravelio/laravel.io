<?php namespace Lio\Bin\UseCases; 

use Lio\Accounts\Member;

class DeletePasteRequest
{
    /**
     * @var \Lio\Accounts\Member
     */
    private $member;
    private $hash;

    public function __construct(Member $member, $hash)
    {
        $this->member = $member;
        $this->hash = $hash;
    }
} 
