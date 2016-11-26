<?php

namespace App\Http\Controllers;

use App\Users\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('users.profile', compact('user'));
    }
}
