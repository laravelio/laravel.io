<?php

namespace App\Notifications;

use App\Contracts\Spam;
use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use NotificationChannels\Telegram\TelegramMessage;

class MarkedAsSpamNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Spam $spam) {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        if (is_null(config('services.telegram-bot-api.channel'))) {
            return;
        }

        $model = Str::singular($this->spam->getMorphClass());

        if ($this->spam instanceof Reply) {
            $url = route('thread', ['thread' => $this->spam->slug()])
                ."#{$this->spam->getKey()}";
        } else {
            $url = route('thread', ['thread' => $this->spam->slug()]);
        }

        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.channel'))
            ->content(
                "There's a {$model} that was reported as spam by multiple users.",
            )
            ->button("View {$model}", $url);
    }
}
