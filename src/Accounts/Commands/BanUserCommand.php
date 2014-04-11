<?php namespace Lio\Accounts\Commands;

use Lio\Accounts\User;

class BanUserCommand
{
    /**
     * @var \Lio\Accounts\User
     */
    public $problem;
    /**
     * @var \Lio\Accounts\User
     */
    public $admin;

    public function __construct(User $problem, User $admin)
    {
        $this->problem = $problem;
        $this->admin = $admin;
    }
} 
