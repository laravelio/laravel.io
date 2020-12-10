<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Jobs\DeleteUser;
use App\Jobs\UpdateProfile;
use App\Policies\UserPolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function edit()
    {
        return view('users.settings.settings');
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->dispatchNow(UpdateProfile::fromRequest(Auth::user(), $request));

        $this->success('settings.updated');

        return redirect()->route('settings.profile');
    }

    public function destroy(Request $request)
    {
        $this->authorize(UserPolicy::DELETE, $user = $request->user());

        $this->dispatchNow(new DeleteUser($user));

        $this->success('settings.deleted');

        return redirect()->route('home');
    }
}
