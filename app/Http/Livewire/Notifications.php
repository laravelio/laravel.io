<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
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

    public $notificationId;

    protected $listeners = ['resetNotifications'];

    public function render(): View
    {
        return view('livewire.notifications', [
            'notifications' => Auth::user()->unreadNotifications()->paginate(10),
        ]);
    }

    public function mount(): void
    {
        abort_if(Auth::guest(), 403);
    }

    public function getNotificationProperty(): DatabaseNotification
    {
        return DatabaseNotification::findOrFail($this->notificationId);
    }

    public function markAsRead(string $notificationId): void
    {
        $this->notificationId = $notificationId;

        $this->authorize(NotificationPolicy::MARK_AS_READ, $this->notification);

        $this->notification->markAsRead();

        $this->emit('NotificationMarkedAsRead', Auth::user()->unreadNotifications()->count());
    }

    public function resetNotifications()
    {
        $this->resetPage();
    }
}
