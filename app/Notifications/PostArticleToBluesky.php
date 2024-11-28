<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Bluesky\BlueskyChannel;
use NotificationChannels\Bluesky\BlueskyPost;

class PostArticleToBluesky extends Notification
{
    use Queueable;

    public function __construct(private Article $article) {}

    public function via($notifiable): array
    {
        return [BlueskyChannel::class];
    }

    public function toBluesky($notifiable)
    {
        return BlueskyPost::make()
            ->text($this->generatePost());
    }

    public function generatePost(): string
    {
        $title = $this->article->title();
        $url = route('articles.show', $this->article->slug());
        $author = $this->article->author();
        $author = $author->bluesky() ? "@{$author->bluesky()}" : $author->name();

        return "{$title} by {$author}\n\n{$url}";
    }

    public function article()
    {
        return $this->article;
    }
}
