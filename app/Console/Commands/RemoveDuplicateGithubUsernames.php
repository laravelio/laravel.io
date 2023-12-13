<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class RemoveDuplicateGithubUsernames extends Command
{
    protected $signature = 'lio:remove-duplicate-github-usernames';

    protected $description = 'Removes duplicate Github usernames from the database';

    public function handle(): void
    {
        $this->info('Removing duplicate Github usernames...');

        $this->info('Duplicate Github usernames removed!');
    }

    private function duplicates()
    {
        return User::whereIn('github_username', function ($query) {
            $query
                ->select('github_username')
                ->from('users')
                ->whereNotNull('github_username')
                ->groupBy('github_username')
                ->havingRaw('COUNT(github_username) > 1');
        })->get();
    }
}
