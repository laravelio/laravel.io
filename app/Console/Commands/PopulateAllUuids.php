<?php

namespace App\Console\Commands;

use App\Jobs\PopulateArticleUuid;
use App\Jobs\PopulateReplyUuid;
use App\Jobs\PopulateThreadUuid;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;

class PopulateAllUuids extends Command
{
    use DispatchesJobs;

    protected $signature = 'populate-all-uuids';

    protected $description = 'Populate all UUID\'s';

    public function handle()
    {
        DB::table('articles')->select('id')->whereNull('uuid')->lazyById()->each(function ($article) {
            $this->dispatch(new PopulateArticleUuid($article->id));
        });

        DB::table('threads')->select('id')->whereNull('uuid')->lazyById()->each(function ($thread) {
            $this->dispatch(new PopulateThreadUuid($thread->id));
        });

        DB::table('replies')->select('id')->whereNull('uuid')->lazyById()->each(function ($reply) {
            $this->dispatch(new PopulateReplyUuid($reply->id));
        });
    }
}
