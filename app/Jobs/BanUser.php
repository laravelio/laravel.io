<?php

namespace App\Jobs;

use App\User;

class BanUser
{
    /**
     * @var \App\User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->ban();
    }
}
