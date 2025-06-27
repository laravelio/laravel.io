<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

final class ArticleApprovedEmail extends Mailable
{
    public function __construct(public string $title, public string $slug) {}

    public function build()
    {
        return $this->subject('Your article has been approved')
            ->markdown('emails.article_approved');
    }
}
