<?php

namespace App\Console\Commands;

use App\Jobs\UpdateUserIdenticonStatus;
use App\Models\User;
use Illuminate\Console\Command;

class BackfillIdenticons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backfill-identicons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfills the github_has_identicon column for users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::whereNotNull('github_id')
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    UpdateUserIdenticonStatus::dispatch($user);
                }

                sleep(2);
            });
    }
}
