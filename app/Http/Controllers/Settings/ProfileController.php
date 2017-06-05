<?php

namespace App\Http\Controllers\Settings;

use Auth;
use App\Jobs\UpdateProfile;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Auth\Middleware\Authenticate;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function edit()
    {
        return view('users.settings.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->dispatchNow(UpdateProfile::fromRequest(Auth::user(), $request));

        $this->success('settings.updated');

        return redirect()->route('settings.profile');
    }
}
