<?php

namespace App\Notifications;

use App\Mail\MentionEmail;
use App\Mail\NewReplyEmail;
use App\Models\MentionAble;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

final class MentionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MentionAble $mentionAble,
    ) {
    }

    public function via(User $user)
    {
        return ['mail', 'database'];
    }

    public function toMail(User $user)
    {
        return (new MentionEmail($this->mentionAble, $user))
            ->to($user->emailAddress(), $user->name());
    }

    public function toDatabase(User $user)
    {
        return [
            'type' => 'mention',
            // 'reply' => $this->reply->id(),
            // 'replyable_id' => $this->reply->replyable_id,
            // 'replyable_type' => $this->reply->replyable_type,
            // 'replyable_subject' => $this->reply->replyAble()->replyAbleSubject(),
        ];
    }
}
