<?php

namespace App\Http\Controllers;

use Auth;
use App\Users\ChangePasswordRequest;
use App\Users\SaveSettingsRequest;
use App\Users\UserRepository;

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

        $this->success('settings.updated');

        return redirect()->route('settings.profile');
    }

    public function password()
    {
        return view('users.settings.password');
    }

    public function updatePassword(ChangePasswordRequest $request, UserRepository $users)
    {
        $users->update(Auth::user(), $request->dataForUpdate());

        $this->success('settings.password.updated');

        return redirect()->route('settings.password');
    }
}
