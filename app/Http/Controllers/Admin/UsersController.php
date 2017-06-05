<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Jobs\BanUser;
use App\Jobs\UnbanUser;
use App\Jobs\DeleteUser;
use App\Policies\UserPolicy;
use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmins;
use Illuminate\Auth\Middleware\Authenticate;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmins::class]);
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function ban(User $user)
    {
        $this->authorize(UserPolicy::BAN, $user);

        $this->dispatchNow(new BanUser($user));

        $this->success('admin.users.banned', $user->name());

        return redirect()->route('admin.users.show', $user->username());
    }

    public function unban(User $user)
    {
        $this->authorize(UserPolicy::BAN, $user);

        $this->dispatchNow(new UnbanUser($user));

        $this->success('admin.users.unbanned', $user->name());

        return redirect()->route('admin.users.show', $user->username());
    }

    public function delete(User $user)
    {
        $this->authorize(UserPolicy::DELETE, $user);

        $this->dispatchNow(new DeleteUser($user));

        $this->success('admin.users.deleted', $user->name());

        return redirect()->route('admin');
    }
}
