<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\UpdateProfileRequest;

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

    public function update(UpdateProfileRequest $request)
    {
        Auth::user()->update($request->only('name', 'email', 'username'));

        $this->success('settings.updated');

        return redirect()->route('settings.profile');
    }
}
