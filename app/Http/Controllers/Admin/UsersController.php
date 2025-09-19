<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmins;
use App\Http\Requests\BanRequest;
use App\Jobs\BanUser;
use App\Jobs\DeleteUserThreads;
use App\Jobs\UnbanUser;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\RedirectResponse;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmins::class]);
    }

    public function ban(BanRequest $request, User $user): RedirectResponse
    {
        $this->authorize(UserPolicy::BAN, $user);

        $this->dispatchSync(new BanUser($user, $request->get('reason')));

        if ($request->willDeleteThreads()) {
            $this->dispatchSync(new DeleteUserThreads($user));
        }

        $this->success($user->name().' was banned!');

        return redirect()->route('profile', $user->username());
    }

    public function unban(User $user): RedirectResponse
    {
        $this->authorize(UserPolicy::BAN, $user);

        $this->dispatchSync(new UnbanUser($user));

        $this->success($user->name().' was unbanned!');

        return redirect()->route('profile', $user->username());
    }
}
