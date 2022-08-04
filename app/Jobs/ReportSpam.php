<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\MarkedAsSpamNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ReportSpam implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private User $user,
        private Model $spammable
    ) {
    }

    public function handle()
    {
        $this->spammable->spammers()->attach($this->user);

        if ($this->shouldNotifyModerators()) {
            Notification::send(
                User::moderators()->get(),
                new MarkedAsSpamNotification($this->spammable),
            );
        }
    }

    private function shouldNotifyModerators()
    {
        return $this->spammable->spammers()->count() >= 3;
    }
}
