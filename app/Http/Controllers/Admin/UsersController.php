<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmins;
use App\Http\Requests\BanRequest;
use App\Jobs\BanUser;
use App\Jobs\DeleteUser;
use App\Jobs\DeleteUserThreads;
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

        if ($request->get('delete_threads')) {
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

    public function delete(User $user): RedirectResponse
    {
        $this->authorize(UserPolicy::DELETE, $user);

        $this->dispatchSync(new DeleteUser($user));

        $this->success($user->name().' was deleted and all of their content was removed!');

        return redirect()->route('admin.users');
    }

    public function deleteThreads(User $user): RedirectResponse
    {
        $this->authorize(UserPolicy::DELETE, $user);

        $this->dispatchSync(new DeleteUserThreads($user));

        $this->success($user->name().' threads were deleted!');

        return redirect()->route('admin.users');
    }

    
}
