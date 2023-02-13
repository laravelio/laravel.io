<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmins;
use App\Http\Requests\BanRequest;
use App\Jobs\BanUser;
use App\Jobs\DeleteUser;
use App\Jobs\UnbanUser;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Queries\SearchUsers;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmins::class]);
    }

    public function index(): View
    {
        if ($adminSearch = request('admin_search')) {
            $users = SearchUsers::get($adminSearch)->appends(['admin_search' => $adminSearch]);
        } else {
            $users = User::latest()->paginate(20);
        }

        return view('admin.users', compact('users', 'adminSearch'));
    }

    public function ban(BanRequest $request, User $user): RedirectResponse
    {
        $this->authorize(UserPolicy::BAN, $user);

        $this->dispatchSync(new BanUser($user, $request->get('reason')));

        $this->success('admin.users.banned', $user->name());

        return redirect()->route('profile', $user->username());
    }

    public function unban(User $user): RedirectResponse
    {
        $this->authorize(UserPolicy::BAN, $user);

        $this->dispatchSync(new UnbanUser($user));

        $this->success('admin.users.unbanned', $user->name());

        return redirect()->route('profile', $user->username());
    }

    public function delete(User $user): RedirectResponse
    {
        $this->authorize(UserPolicy::DELETE, $user);

        $this->dispatchSync(new DeleteUser($user));

        $this->success('admin.users.deleted', $user->name());

        return redirect()->route('admin.users');
    }
}
