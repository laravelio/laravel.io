<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationCount extends Component
{
    public $count;

    protected $listeners = [
        'notificationMarkedAsRead' => 'updateCount',
    ];

    public function render()
    {
        $this->count = Auth::user()->unreadNotifications()->count();

        return view('livewire.notification_count', [
            'count' => $this->count,
        ]);
    }

    public function updateCount($count)
    {
        return $count;
    }
}
