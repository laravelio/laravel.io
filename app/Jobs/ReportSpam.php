<?php

namespace App\Jobs;

use App\Models\Thread;
use App\Models\User;
use App\Notifications\ThreadMarkedAsSpamNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ReportSpam implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private User $user,
        private Thread $thread
    ) {
    }

    public function handle()
    {
        $this->user->spamming()->attach($this->thread->getKey());

        if ($this->shouldNotifyModerators()) {
            Notification::send(
                User::moderators()->get(),
                new ThreadMarkedAsSpamNotification($this->thread),
            );
        }
    }

    private function shouldNotifyModerators()
    {
        return $this->thread->spammers()->count() >= 3;
    }
}
