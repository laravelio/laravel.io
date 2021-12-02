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

    public function __construct(
        private Article $article
    ) {
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $url = route('articles.show', $this->article->slug());

        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.channel'))
            ->content($this->content())
            ->button('View Article', $url);
    }

    private function content(): string
    {
        $content = "*New Article Submitted!*\n\n";
        $content .= 'Title: '.$this->article->title()."\n";
        $content .= 'By: [@'.$this->article->author()->username().']('.route('profile', $this->article->author()->username()).')';

        return $content;
    }
}
