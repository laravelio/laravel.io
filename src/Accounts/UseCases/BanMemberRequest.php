<?php namespace Lio\Accounts\UseCases; 

class BanMemberRequest
{
    public $problemMemberId;
    public $moderatorId;

    public function __construct($problemMemberId, $moderatorId)
    {
        $this->problemMemberId = $problemMemberId;
        $this->moderatorId = $moderatorId;
    }
} 
