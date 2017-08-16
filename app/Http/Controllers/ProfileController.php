<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('users.profile', compact('user'));
    }

    public function avatar(User $user, Request $request)
    {
        $avatar = new InitialAvatar();

        $size = $request->get('s', 100);

        return $avatar
            ->name($user->name())
            ->background('#149c82')
            ->size($size)
            ->generate()
            ->response('png', 100);
    }
}
