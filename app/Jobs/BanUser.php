<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;

final class BanUser
{

    public function __construct(private User $user, private string $banned_reason)
    {

    }

    public function handle(): void
    {
        $this->user->banned_at = Carbon::now();
		$this->user->banned_reason = $this->banned_reason;
        $this->user->save();
    }
}
