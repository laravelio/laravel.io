<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function __invoke()
    {
        return view('users.notifications');
    }
}
