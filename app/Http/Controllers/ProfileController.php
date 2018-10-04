<?php

namespace App\Http\Controllers;

use App\User;
use App\Jobs\DeleteUser;
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

    /**
     * Delete the current user profile.
     * All related data (threads, replies, etc) will be deleted alongside.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        $user = auth()->user();

        $this->dispatchNow(new DeleteUser($user));

        $this->success('settings.users.left', $user->name());

        return redirect()->route('login');
    }
}
