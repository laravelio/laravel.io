<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

final class ThreadDeletedEmail extends Mailable
{
    public function __construct(public string $threadSubject, public string $reason) {}

    public function build()
    {
        return $this->subject('Your thread on Laravel.io was removed')
            ->markdown('emails.thread_deleted');
    }
}
