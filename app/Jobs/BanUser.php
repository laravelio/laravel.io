<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;

final class BanUser
{
    public function __construct(private User $user, private $msg)
    {
    }

    public function handle(): void
    {
        $this->user->banned_at = Carbon::now();
        $this->user->ban_msg = $this->msg;
        $this->user->save();
    }
}
