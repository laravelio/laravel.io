<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Middleware\Authenticate;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function index()
    {
        $notifications = auth()->user()->notifications()->get();

        return view('users.notifications', compact('notifications'));
    }
}
