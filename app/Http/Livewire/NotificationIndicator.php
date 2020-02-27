<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationIndicator extends Component
{
    public $hasNotification;

    protected $listeners = [
        'notificationMarkedAsRead' => 'setHasNotification',
    ];

    public function render()
    {
        $this->hasNotification = Auth::user()->unreadNotifications()->count() > 0;

        return view('livewire.notification_indicator', [
            'hasNotification' => $this->hasNotification
        ]);
    }

    public function setHasNotification($count)
    {
        return $count > 0;
    }
}
