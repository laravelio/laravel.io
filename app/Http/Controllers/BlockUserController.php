<?php

namespace App\Http\Controllers;

use App\Jobs\BlockUser;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class BlockUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function __invoke(Request $request, User $user)
    {
        $this->authorize(UserPolicy::BLOCK, $user);

        $this->dispatchSync(new BlockUser($request->user(), $user));

        $this->success('settings.user.blocked');

        return redirect()->route('profile', $user->username());
    }
}
