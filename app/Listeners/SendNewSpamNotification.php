<?php

namespace App\Listeners;

use App\Contracts\Spam;
use App\Events\SpamWasReported;
use App\Notifications\MarkedAsSpamNotification;
use Illuminate\Notifications\AnonymousNotifiable;

final class SendNewSpamNotification
{
    public function __construct(private AnonymousNotifiable $notifiable)
    {
    }

    public function handle(SpamWasReported $event): void
    {
        if ($this->shouldNotifyModerators($event->spam)) {
            $this->notifiable->notify(new MarkedAsSpamNotification($event->spam));
        }
    }

    private function shouldNotifyModerators(Spam $spam): bool
    {
        $spamReportCount = $spam->spamReportersRelation()->count();

        return $spamReportCount > 0 && $spamReportCount % 3 == 0;
    }
}
