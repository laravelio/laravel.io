<?php

namespace App\Notifications;

use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class MarkedAsSpamNotification extends Notification
{
    use Queueable;

    public function __construct(protected Model $spammable)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (
            ! empty(config('services.telegram-bot-api.token')) &&
            ! empty(config('services.telegram-bot-api.channel'))
        ) {
            return ['telegram'];
        }

        return [];
    }

    public function toTelegram($notifiable)
    {
        $alias = $this->spammable->getMorphClass();
        $model = str($alias)->singular();
        $url = route('thread', ['thread' => $this->spammable]);
        if ($this->spammable instanceof Reply) {
            $url = route('thread', ['thread' => $this->spammable->thread])
                ."#{$this->spammable->getKey()}";
        }

        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.channel'))
            ->content(
                "There's a {$model} that may need your moderation as it is marked as spam by a few people",
            )
            ->button("View {$model}", $url);
    }
}
