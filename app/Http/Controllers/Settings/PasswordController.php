<?php

namespace App\Http\Controllers\Settings;

use Auth;
use App\Jobs\UpdatePassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Auth\Middleware\Authenticate;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
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
