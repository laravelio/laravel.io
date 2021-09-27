<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmins;
use App\Jobs\BanUser;
use App\Jobs\DeleteUser;
use App\Jobs\UnbanUser;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Queries\SearchUsers;
use Illuminate\Auth\Middleware\Authenticate;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmins::class]);
    }

    public function index()
    {
        if ($adminSearch = request('admin_search')) {
            $users = SearchUsers::get($adminSearch)->appends(['admin_search' => $adminSearch]);
        } else {
            $users = User::latest()->paginate(20);
        }

        return view('admin.users', compact('users', 'adminSearch'));
    }

    public function ban(User $user)
    {
        $this->authorize(UserPolicy::BAN, $user);

        $this->dispatchNow(new BanUser($user));

        $this->success('admin.users.banned', $user->name());

        return redirect()->route('profile', $user->username());
    }

    public function unban(User $user)
    {
        $this->authorize(UserPolicy::BAN, $user);

        $this->dispatchNow(new UnbanUser($user));

        $this->success('admin.users.unbanned', $user->name());

        return redirect()->route('profile', $user->username());
    }

    public function delete(User $user)
    {
        $this->authorize(UserPolicy::DELETE, $user);

        $this->dispatchNow(new DeleteUser($user));

        $this->success('admin.users.deleted', $user->name());

        return redirect()->route('admin');
    }
}
