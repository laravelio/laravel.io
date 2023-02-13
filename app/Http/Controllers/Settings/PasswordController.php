<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Jobs\UpdatePassword;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\RedirectResponse;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $this->dispatchSync(new UpdatePassword($request->user(), $request->newPassword()));

        $this->success('settings.password.updated');

        return redirect()->route('settings.profile');
    }
}
