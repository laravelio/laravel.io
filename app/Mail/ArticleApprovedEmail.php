<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Mail\Mailable;

final class ArticleApprovedEmail extends Mailable
{
    public bool $deleteWhenMissingModels = true;

    public function __construct(public Article $article) {}

    public function build()
    {
        return $this->subject('Your article has been approved')
            ->markdown('emails.article_approved');
    }
}
