<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class RemoveDuplicateGithubUsernames extends Command
{
    protected $signature = 'lio:remove-duplicate-github-usernames';

    protected $description = 'Removes duplicate Github usernames from the database';

    public function handle(): void
    {
        $this->info('Removing duplicate Github usernames...');

        $this->removeDuplicates();

        $this->info('Duplicate Github usernames removed!');
    }

    private function removeDuplicates(): void
    {
        $this
            ->duplicates()
            ->groupBy('github_username')
            ->each(function (Collection $duplicates) {

                $uniqueUsernames = [];

                foreach($duplicates as $user) {

                    // set github_username to null if the user has no github_id
                    if (! $user->github_id) {
                        $user->update(['github_username' => null]);
                        continue;
                    }

                    // fetch the user from GitHub
                    $githubUser = $this->fetchFromGithub($user);

                    // if the user doesn't exist on GitHub, set github_username to null
                    if (! $githubUser || ! $githubUser->login) {
                        $user->update(['github_username' => null, 'github_id' => null]);
                        continue;
                    }

                    // if the user's github_username marked as unique, set github_username to null
                    if (in_array($githubUser->login, $uniqueUsernames)) {
                        //TODO: delete user?
                        $user->update(['github_username' => null, 'github_id' => null]);
                        continue;
                    }

                    // if the user exists on GitHub, update the user's github_username
                    $user->update(['github_username' => $githubUser->login]);

                    // add the user's github_username to the uniqueUsernames array
                    $uniqueUsernames[] = $githubUser->login;
                }
            });
    }

    private function fetchFromGithub(User $user): ?object
    {
        $response = Http::get("https://api.github.com/user/{$user->github_id}");

        if ($response->failed()) {
            return null;
        }

        return $response->object();
    }

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
