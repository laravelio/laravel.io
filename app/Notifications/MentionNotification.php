<?php

namespace App\Notifications;

use App\Contracts\MentionAble;
use App\Mail\MentionEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notification;

final class MentionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public MentionAble $mentionAble)
    {
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
        $replyAble = $this->mentionAble->mentionedIn();

        return [
            'type' => 'mention',
            'replyable_id' => $replyAble->id,
            'replyable_type' => array_search(get_class($replyAble), Relation::morphMap()),
            'replyable_subject' => $this->mentionAble->mentionedIn()->subject(),
        ];
    }
}
