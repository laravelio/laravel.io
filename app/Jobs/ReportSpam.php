<?php

namespace App\Jobs;

use App\Contracts\Spam;
use App\Events\SpamWasReported;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReportSpam implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private User $user, private Spam $spam)
    {
    }

    public function handle(): void
    {
        $this->spam->spamReportersRelation()->attach($this->user);

        event(new SpamWasReported($this->spam));
    }
}
