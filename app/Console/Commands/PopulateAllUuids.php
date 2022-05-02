<?php

namespace App\Console\Commands;

use App\Jobs\PopulateArticleUuid;
use App\Jobs\PopulateReplyUuid;
use App\Jobs\PopulateThreadUuid;
use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class PopulateAllUuids extends Command
{
    use DispatchesJobs;

    protected $signature = 'populate-all-uuids';

    protected $description = 'Populate all UUID\'s';

    public function handle()
    {
        foreach (Article::where('uuid', null)->lazyById() as $article) {
            $this->dispatch(new PopulateArticleUuid($article));
        }

        foreach (Thread::where('uuid', null)->lazyById() as $thread) {
            $this->dispatch(new PopulateThreadUuid($thread));
        }

        foreach (Reply::where('uuid', null)->lazyById() as $reply) {
            $this->dispatch(new PopulateReplyUuid($reply));
        }
    }
}
