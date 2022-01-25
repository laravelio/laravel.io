<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArticleDeletedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Article $article,
        public $message
    ) {
    }

    public function build()
    {
        return $this->subject('Your article has been deleted by Admin')
            ->markdown('emails.article_deleted');
    }
}
