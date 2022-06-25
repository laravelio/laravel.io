<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\EmailAddressWasChanged;
use Illuminate\Contracts\Auth\MustVerifyEmail;

final class RenewEmailVerificationNotification
{
    public function handle(EmailAddressWasChanged $event): void
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
