<?php

namespace App\Jobs;

use App\User;

class ConfirmUser
{
    /**
     * @var \App\User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): User
    {
        $this->user->update(['confirmed' => true, 'confirmation_code' => null]);

        return $this->user;
    }
}
