<?php namespace Lio\Accounts\UseCases; 

class BanMemberRequest
{
    private $problemMemberId;
    private $moderatorId;

    public function __construct($problemMemberId, $moderatorId)
    {
        $this->problemMemberId = $problemMemberId;
        $this->moderatorId = $moderatorId;
    }
} 
