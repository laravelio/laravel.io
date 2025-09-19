<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

final class BanUser implements ShouldQueue
{
    use Queueable;

    public function __construct(private User $user, private $reason) {}

    public function handle(): void
    {
        $this->user->banned_at = Carbon::now();
        $this->user->banned_reason = $this->reason;
        $this->user->save();
    }
}
