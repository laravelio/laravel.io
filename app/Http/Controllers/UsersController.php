<?php
namespace Lio\Http\Controllers;

use Auth;
use Input;
use Lio\Accounts\UserRepository;
use Lio\Accounts\UserUpdater;
use Lio\Accounts\UserUpdaterListener;
use Session;

class UsersController extends Controller implements UserUpdaterListener
{
    /**
     * @var \Lio\Accounts\UserRepository
     */
    private $users;

    /**
     * @var \Lio\Accounts\UserUpdater
     */
    private $updater;

    /**
     * @param \Lio\Accounts\UserRepository $users
     * @param \Lio\Accounts\UserUpdater $updater
     */
    public function __construct(UserRepository $users, UserUpdater $updater)
    {
        $this->users = $users;
        $this->updater = $updater;
    }

    public function getProfile($userName)
    {
        $user = $this->users->requireByName($userName);

        $threads = $user->getLatestThreadsPaginated(5);
        $replies = $user->getLatestRepliesPaginated(5);

        return view('users.profile', compact('user', 'threads', 'replies'));
    }

    public function getSettings($userName)
    {
        $user = $this->users->requireByName($userName);

        // Make sure that the user which is updated is the one who is currently logged in.
        if (Auth::user()->id !== $user->id) {
            abort(403);
        }

        return view('users.settings', compact('user'));
    }

    public function putSettings($userName)
    {
        $user = $this->users->requireByName($userName);

        // Make sure that the user which is updated is the one who is currently logged in.
        if (Auth::user()->id !== $user->id) {
            abort(403);
        }

        return $this->updater->update($this, $user, Input::only('name', 'email'));
    }

    public function getThreads($userName)
    {
        $user = $this->users->requireByName($userName);

        $threads = $user->getLatestThreadsPaginated(10);

        return view('users.threads', compact('user', 'threads'));
    }

    public function getReplies($userName)
    {
        $user = $this->users->requireByName($userName);

        $replies = $user->getLatestRepliesPaginated(10);

        return view('users.replies', compact('user', 'replies'));
    }

    public function userValidationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function userUpdated($user, $emailChanged = false)
    {
        if ($emailChanged) {
            Session::put('success', 'Settings updated. An email confirmation was sent to ' . $user->email);
        } else {
            Session::put('success', 'Settings updated');
        }

        return redirect()->route('user.settings', $user->name);
    }
}
