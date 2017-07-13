<?php

namespace App\Jobs;

use App\User;
use App\Models\Reply;
use App\Notifications\NewReply;

class NotifyNewReply
{
    /**
     * @var \App\Models\Thread
     */
    private $thread;

    /**
     * @var \App\User
     */
    private $user;

    public function __construct(Reply $reply)
    {
        $this->thread = $reply->replyAble();
        $this->user = $reply->author();
    }

    public function handle()
    {
        \Notification::send($this->thread->subscribersWhereNot($this->user)->get(), new NewReply($this->thread));
    }
}
