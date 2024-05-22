<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On; 

final class NotificationIndicator extends Component
{
    public $hasNotification;

    public function render(): View
    {
        $this->hasNotification = $this->setHasNotification(
            Auth::user()->unreadNotifications()->count(),
        );

        return view('livewire.notification_indicator', [
            'hasNotification' => $this->hasNotification,
        ]);
    }

    #[On('NotificationMarkedAsRead')] 
    public function setHasNotification(int $count): bool
    {
        return $count > 0;
    }
}
