<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;

final class BanUser
{
	private string $ban_message;
    public function __construct(private User $user, string $ban_message)
    {
		$this->ban_message = $ban_message;
    }

    public function handle(): void
    {
        $this->user->banned_at = Carbon::now();
		$this->user->ban_message = $this->ban_message;
        $this->user->save();
    }
}
