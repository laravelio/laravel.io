<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationClear extends Component
{
    public bool $isClearable;

    protected $listeners = [
        'NotificationMarkedAsRead' => 'setIsClearable',
    ];

    public function render()
    {
        $this->isClearable = $this->setIsClearable(
            Auth::user()->unreadNotifications()->count(),
        );

        return view('livewire.notification-clear', [
            'isClearable' => $this->isClearable
        ]);
    }

    public function setIsClearable(int $count): bool
    {
        return $count > 0;
    }

    public function clearAllNotifications(): void
    {
        $user = Auth::user();

        $user->unreadNotifications()->get()->markAsRead();

        $this->emitTo('notifications', 'resetNotifications');
        $this->emit('NotificationMarkedAsRead', $user->unreadNotifications()->count());
    }
}
