<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class ArticleSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    private Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $url = route('articles.show', $this->article->slug());
        return TelegramMessage::create()
            ->to(env('TELEGRAM_LARAVELIO_CHANNEL'))
            ->content($this->content())
            ->button('View article', $url);
    }

    private function content(): string
    {
        $content = "*New article submitted!*\n\n";
        $content .= 'Title: '.$this->article->title()."\n";
        $content .= 'By: [@'.$this->article->author()->username().']('.route('profile', $this->article->author()->username()).')';

        return $content;
    }
}
