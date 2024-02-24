<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Social\GithubUserApi;
use Exception;

class ResolveDuplicateGithubUsernames extends Command
{
    protected $signature = 'lio:resolve-duplicate-github-usernames';

    protected $description = 'Resolve duplicate GitHub usernames from the database';

    public function __construct(
        private readonly GithubUserApi $github
    ){
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Resolving duplicate Github usernames...');

        $this->resolveDuplicates();

        $this->info('Duplicate Github usernames resolved!');
    }

    /**
     * Resolve duplicate github_username
     */
    private function resolveDuplicates(): void
    {
        $this
            ->duplicates()
            ->groupBy('github_username')
            ->each(function (Collection $users) {

                $uniqueUsernames = [];

                // order from the latest user to the oldest
                $users = $users->sortByDesc('created_at');

                // resolve each user with the same github_username
                foreach($users as $user) {

                    // fetch the user from GitHub API
                    try {
                        $githubUser = $this->github->find($user->github_id);
                    } catch (Exception $e) {
                        $message = $e->getCode() === 404 ? "Error 404: github_id - $user->github_id" : $e->getMessage();
                        $this->error($message);
                        continue;
                    }

                    // if the user doesn't exist on GitHub
                    if (! $githubUser || ! $githubUser->login) {
                        $user->update(['github_username' => null]);
                        continue;
                    }

                    // if the user's github_username marked as unique
                    if (in_array($githubUser->login, $uniqueUsernames)) {
                        $user->update(['github_username' => null]);
                        continue;
                    }

                    // if the user exists on GitHub, update the user's github_username
                    $user->update(['github_username' => $githubUser->login]);

                    $this->info("Updated user: {$user->id} with github_username: {$githubUser->login}");

                    // mark the user's github_username as unique
                    $uniqueUsernames[] = $githubUser->login;
                }
            });
    }

    /**
     * Get all users with duplicate github_username
     * @return Collection
     */
    private function duplicates(): Collection
    {
        return User::whereIn('github_username', function ($query) {
            $query
                ->select('github_username')
                ->from('users')
                ->whereNotNull('github_username')
                ->where('github_username', '!=', '')
                ->groupBy('github_username')
                ->havingRaw('COUNT(github_username) > 1');
        })->get();
    }
}
