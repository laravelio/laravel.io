<?php

namespace App\Http\Livewire;

use App\Policies\NotificationPolicy;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use WithPagination, AuthorizesRequests;

    public $notificationId;

    public function render()
    {
        return view('livewire.notifications', [
            'notifications' => $this->user->unreadNotifications()->paginate(10),
        ]);
    }

    public function mount()
    {
        if (! $this->user) {
            abort(403);
        }
    }

    public function getUserProperty(): ?User
    {
        return Auth::user();
    }

    public function getNotificationProperty(): DatabaseNotification
    {
        return DatabaseNotification::findOrFail($this->notificationId);
    }

    public function markAsRead($notificationId)
    {
        $this->notificationId = $notificationId;
        $this->authorize(NotificationPolicy::MARK_AS_READ, $this->notification);

        $this->notification->markAsRead();
        $unreadNotifications = $this->user->unreadNotifications()->paginate(10);
        $this->emit('notificationMarkedAsRead', $unreadNotifications->total());

        return $unreadNotifications;
    }
}
