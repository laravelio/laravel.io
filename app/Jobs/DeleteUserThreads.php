<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

final class DeleteUserThreads implements ShouldQueue
{
    use Queueable;
    
    public function __construct(private User $user) {}

    public function handle(): void
    {
        $this->user->deleteThreads();
    }
}
