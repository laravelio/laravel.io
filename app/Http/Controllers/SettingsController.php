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
        $users->update(Auth::user(), $request->only('name', 'email', 'username'));

        return redirect()->route('settings.profile');
    }

    public function password()
    {
        return view('users.settings.password');
    }

    public function updatePassword(ChangePasswordRequest $request, UserRepository $users)
    {
        $users->update(Auth::user(), $request->dataForUpdate());

        return redirect()->route('settings.password');
    }
}
