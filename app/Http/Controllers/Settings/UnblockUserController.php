<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Jobs\UnblockUser;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class UnblockUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function __invoke(Request $request, User $user)
    {
        $this->dispatchSync(new UnblockUser($request->user(), $user));

        $this->success('settings.user.unblocked');

        return redirect()->route('settings.profile');
    }
}
