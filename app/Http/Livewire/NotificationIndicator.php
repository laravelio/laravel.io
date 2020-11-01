<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

final class NotificationIndicator extends Component
{
    public $hasNotification;

    protected $listeners = [
        'NotificationMarkedAsRead' => 'setHasNotification',
    ];

    public function render(): View
    {
        $this->hasNotification = $this->setHasNotification(
            Auth::user()->unreadNotifications()->count(),
        );

        return view('livewire.notification_indicator', [
            'hasNotification' => $this->hasNotification,
        ]);
    }

    public function setHasNotification(int $count): bool
    {
        return $count > 0;
    }
}
