<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class NotificationIndicator extends Component
{
    public bool $hasNotification = false;

    public function render(): View
    {
        $this->hasNotification = Auth::user()?->unreadNotifications()->exists() ?? false;

        return view('livewire.notification_indicator', [
            'hasNotification' => $this->hasNotification,
        ]);
    }

    #[On('NotificationMarkedAsRead')]
    public function setHasNotification(int $count): void
    {
        $this->hasNotification = $count > 0;
    }
}
