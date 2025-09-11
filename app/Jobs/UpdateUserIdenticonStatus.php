<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Social\GithubUserApi;

final class UpdateUserIdenticonStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private User $user) {}

    public function handle(GithubUserApi $github): void
    {
        $hasIdenticon = $github->hasIdenticon($this->user->githubId());
        $this->user->update(['has_identicon' => $hasIdenticon]);
    }
}