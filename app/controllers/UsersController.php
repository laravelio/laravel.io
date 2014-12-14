<?php

use Lio\Accounts\UserRepository;
use Lio\Accounts\UserUpdater;
use Lio\Accounts\UserUpdaterListener;

class UsersController extends BaseController implements UserUpdaterListener
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

        // Make sure that the user which is updated is the one who is currently logged in.
        if (Auth::user()->id !== $user->id) {
            App::abort(403);
        }

        $threads = $user->getLatestThreadsPaginated(5);
        $replies = $user->getLatestRepliesPaginated(5);

        $this->view('users.profile', compact('user', 'threads', 'replies'));
    }

    public function getSettings($userName)
    {
        $user = $this->users->requireByName($userName);

        $this->view('users.settings', compact('user'));
    }

    public function putSettings($userName)
    {
        $user = $this->users->requireByName($userName);

        return $this->updater->update($this, $user, Input::only('email'));
    }

    public function getThreads($userName)
    {
        $user = $this->users->requireByName($userName);

        $threads = $user->getLatestThreadsPaginated(10);

        $this->view('users.threads', compact('user', 'threads'));
    }

    public function getReplies($userName)
    {
        $user = $this->users->requireByName($userName);

        $replies = $user->getLatestRepliesPaginated(10);

        $this->view('users.replies', compact('user', 'replies'));
    }

    public function userValidationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function userUpdated($user, $emailChanged = false)
    {
        if ($emailChanged) {
            Session::flash('success', 'Settings updated. An email confirmation was sent to ' . $user->email);
        } else {
            Session::flash('success', 'Settings updated');
        }

        return Redirect::route('user', $user->name);
    }
}