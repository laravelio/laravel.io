<?php

namespace App\Http\Livewire;

use App\Policies\NotificationPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

final class Notifications extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public $notificationCount = 0;

    public function render(): View
    {
        $notifications = Auth::user()->unreadNotifications()->paginate(10);
        $lastPage = count($notifications) == 0 ? $notifications->lastPage() : null;

        return view('livewire.notifications', [
            'notifications' => Auth::user()->unreadNotifications()->paginate(10, ['*'], 'page', $lastPage),
        ]);
    }

    public function mount(): void
    {
        abort_if(Auth::guest(), 403);

        $this->notificationCount = Auth::user()->unreadNotifications()->count();
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = DatabaseNotification::findOrFail($notificationId);

        $this->authorize(NotificationPolicy::MARK_AS_READ, $notification);

        $notification->markAsRead();

        $this->notificationCount--;

        $this->emit('NotificationMarkedAsRead', $this->notificationCount);
    }
}
