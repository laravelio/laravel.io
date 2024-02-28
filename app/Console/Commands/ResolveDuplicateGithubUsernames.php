<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Social\GithubUserApi;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class ResolveDuplicateGithubUsernames extends Command
{
    protected $signature = 'lio:resolve-duplicate-github-usernames';

    protected $description = 'Resolve duplicate GitHub usernames from the database';

    public function __construct(private GithubUserApi $github)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Resolving duplicate Github usernames...');

        $this->duplicates()
            ->groupBy('github_username')
            ->each(function (Collection $users) {
                $uniqueUsernames = [];

                // Order from the latest user to the oldest
                $users = $users->sortByDesc('created_at');

                // Resolve each user with the same github_username
                foreach ($users as $user) {
                    try {
                        $githubUser = $this->github->find($user->github_id);
                    } catch (Exception $e) {
                        $message = $e->getCode() === 404 ? "Error 404: github_id - $user->github_id" : $e->getMessage();
                        $this->error($message);

                        continue;
                    }

                    // If the user doesn't exist on GitHub
                    if (! $githubUser || ! $githubUser->login()) {
                        $user->update(['github_username' => null]);

                        continue;
                    }

                    // If the user's github_username marked as unique
                    if (in_array($githubUser->login(), $uniqueUsernames)) {
                        $user->update(['github_username' => null]);

                        continue;
                    }

                    // If the user exists on GitHub, update the user's github_username
                    $user->update(['github_username' => $githubUser->login()]);

                    $this->info("Updated user: {$user->id} with github_username: {$githubUser->login()}");

                    // Mark the user's github_username as unique
                    $uniqueUsernames[] = $githubUser->login();
                }
            });

        $this->info('Duplicate Github usernames resolved!');
    }

    private function duplicates(): Collection
    {
        return User::whereIn('github_username', function ($query) {
            $query->select('github_username')
                ->from('users')
                ->whereNotNull('github_username')
                ->where('github_username', '!=', '')
                ->groupBy('github_username')
                ->havingRaw('COUNT(github_username) > 1');
        })->get();
    }
}
