<?php

namespace App\Notifications;

use App\Models\User;
use App\Mail\ArticleDeletedEmail;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleDeletedNotification extends Notification
{
    use Queueable;

    public function __construct(
        private Article $article,
        private $message
    ){
    }

    public function via(User $user)
    {
        return ['mail', 'database'];
    }

    public function toMail(User $user)
    {
        return (new ArticleDeletedEmail($this->article, $this->message))
            ->to($user->emailAddress(), $user->name());
    }

    public function toDatabase(User $user)
    {
        return [
            'type' => 'article_deleted',
            'article_title' => $this->article->title(),
            'article_slug' => $this->article->slug(),
        ];
    }
}
