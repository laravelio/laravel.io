<?php

namespace App\Http\Controllers;

use App\User;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('users.profile', compact('user'));
    }
}
