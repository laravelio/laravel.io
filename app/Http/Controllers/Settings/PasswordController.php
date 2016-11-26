<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\UpdatePasswordRequest;
use App\Users\UserRepository;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('users.settings.password');
    }

    public function update(UpdatePasswordRequest $request, UserRepository $users)
    {
        $users->update(Auth::user(), $request->changed());

        $this->success('settings.password.updated');

        return redirect()->route('settings.password');
    }
}
