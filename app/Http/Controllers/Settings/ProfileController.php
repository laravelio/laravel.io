<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\UpdateProfileRequest;
use App\Users\UserRepository;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('users.settings.profile');
    }

    public function update(UpdateProfileRequest $request, UserRepository $users)
    {
        $users->update(Auth::user(), $request->only('name', 'email', 'username'));

        $this->success('settings.updated');

        return redirect()->route('settings.profile');
    }
}
