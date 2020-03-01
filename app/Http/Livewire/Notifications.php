<?php

namespace App\Http\Livewire;

use App\Policies\NotificationPolicy;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

final class Notifications extends Component
{
    use WithPagination, AuthorizesRequests;

    public $notificationId;

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

    public function markAsRead(string $notificationId): LengthAwarePaginator
    {
        $this->notificationId = $notificationId;

        $this->authorize(NotificationPolicy::MARK_AS_READ, $this->notification);

        $this->notification->markAsRead();

        $unreadNotifications = Auth::user()->unreadNotifications()->paginate(10);

        $this->emit('NotificationMarkedAsRead', $unreadNotifications->total());

        return $unreadNotifications;
    }
}
