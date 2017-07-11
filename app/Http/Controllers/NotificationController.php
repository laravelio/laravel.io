<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        return view('users.notifications');
    }
}
