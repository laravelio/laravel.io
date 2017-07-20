<?php

namespace App\Http\Controllers;

use App\Jobs\MarkNotificationAsRead;
use Illuminate\Auth\Middleware\Authenticate;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);

        return view('users.notifications', compact('notifications'));
    }

    public function markAsRead(string $notification)
    {
        $this->dispatchNow(new MarkNotificationAsRead($notification, auth()->user()));
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
}
