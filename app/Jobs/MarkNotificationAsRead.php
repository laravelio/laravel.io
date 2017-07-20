<?php

namespace App\Jobs;

use App\User;

class MarkNotificationAsRead
{
    /**
     * @var string
     */
    private $notification;

    /**
     * @var \App\User
     */
    private $user;

    public function __construct(string $notification, User $user)
    {
        $this->notification = $notification;
        $this->user = $user;
    }

    public function handle()
    {
        $notification = $this->user->notifications()->findOrFail($this->notification);
        $notification->markAsRead();
    }
}
