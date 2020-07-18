<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

class PostArticleToTwitter extends Notification
{
    use Queueable;

    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function via($notifiable)
    {
        return [TwitterChannel::class];
    }

    public function toTwitter($notifiable)
    {
        $title = $this->article->title();
        $url = route('articles.show', $this->article->slug());
        $author = $this->article->author()->name();

        return new TwitterStatusUpdate("{$title} - {$author}\n\n{$url}");
    }
}
