<?php

namespace App\Jobs;

use App\Models\User;
use App\Social\GithubUserApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class UpdateUserIdenticonStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected User $user) {}

    public function handle(GithubUserApi $github): void
    {
        $hasIdenticon = $github->hasIdenticon($this->user->githubId());

        $this->user->update(['github_has_identicon' => $hasIdenticon]);
    }
}
