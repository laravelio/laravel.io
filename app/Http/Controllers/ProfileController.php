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

    public function avatar(User $user)
    {
        $avatar = new InitialAvatar();

        return $avatar
            ->name($user->name())
            ->background('#2C3E50')
            ->size(100)
            ->generate()
            ->response('png', 100);
    }
}
