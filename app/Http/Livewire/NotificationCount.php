<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationCount extends Component
{
    public $max = 9;

    public $class;

    protected $listeners = [
        'notificationMarkedAsRead' => 'updateCount',
    ];

    public function render()
    {
        $notificationCount = Auth::user()->unreadNotifications()->count();

        return view('livewire.notification-count', [
            'count' => ($notificationCount > $this->max) ? "{$this->max}+" : $notificationCount,
            'class' => $this->class,
        ]);
    }

    public function mount($max, $class = null)
    {
        $this->max = $max;
        $this->class = $class;
    }

    public function updateCount($count)
    {
        return $count;
    }
}
