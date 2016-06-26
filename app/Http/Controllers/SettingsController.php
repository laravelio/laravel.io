<?php

namespace Lio\Http\Controllers;

use Auth;
use Lio\Users\ChangePasswordRequest;
use Lio\Users\SaveSettingsRequest;
use Lio\Users\UserRepository;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('users.settings.profile');
    }

    public function updateProfile(SaveSettingsRequest $request, UserRepository $users)
    {
        $user = $users->update(Auth::user(), $request->only('name', 'email', 'username'));

        // Unfortunately we need to do this to make the tests pass.
        Auth::setUser($user);

        return redirect()->route('settings.profile');
    }

    public function password()
    {
        return view('users.settings.password');
    }

    public function updatePassword(ChangePasswordRequest $request, UserRepository $users)
    {
        $user = $users->update(Auth::user(), $request->fromForm());

        // Unfortunately we need to do this to make the tests pass.
        Auth::setUser($user);

        return redirect()->route('settings.password');
    }
}
