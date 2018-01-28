<?php

namespace App\Jobs;

use App\User;

final class DeleteUser
{
    /**
     * @var \App\User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->delete();
    }
}
