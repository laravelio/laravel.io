<?php

namespace App\Jobs;

use App\Users\User;
use Illuminate\Queue\SerializesModels;

class BanUser
{
    use SerializesModels;

    /**
     * @var \App\Users\User
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
