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

    public function __construct(
        private Article $article
    ) {
    }

    public function via($notifiable)
    {
        return [TwitterChannel::class];
    }

    public function toTwitter($notifiable)
    {
        return new TwitterStatusUpdate($this->generateTweet());
    }

    public function generateTweet()
    {
        $title = $this->article->title();
        $url = route('articles.show', $this->article->slug());
        $author = $this->article->author();
        $author = $author->twitter() ? "@{$author->twitter()}" : $author->name();

        return "{$title} by {$author}\n\n{$url}";
    }

    public function article()
    {
        return $this->article;
    }
}
