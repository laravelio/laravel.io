<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Jobs\UpdatePassword;
use Auth;
use App\Http\Requests\UpdatePasswordRequest;

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

    public function update(UpdatePasswordRequest $request)
    {
        $this->dispatchNow(new UpdatePassword(Auth::user(), $request->newPassword()));

        $this->success('settings.password.updated');

        return redirect()->route('settings.password');
    }
}
