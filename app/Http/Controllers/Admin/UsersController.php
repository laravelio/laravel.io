<?php

namespace Lio\Http\Controllers\Admin;

use Input;
use Lio\Accounts\RoleRepository;
use Lio\Accounts\UserRepository;
use Lio\Forum\Threads\ThreadRepository;
use Lio\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * @var \Lio\Accounts\UserRepository
     */
    private $users;

    /**
     * @var \Lio\Accounts\RoleRepository
     */
    private $roles;

    /**
     * @var \Lio\Forum\Threads\ThreadRepository
     */
    private $threads;

    public function __construct(UserRepository $users, RoleRepository $roles, ThreadRepository $threads)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->threads = $threads;
    }

    public function getIndex()
    {
        $users = $this->users->getAllPaginated(100);

        return view('admin.users.index', compact('users'));
    }

    public function search()
    {
        $users = $this->users->search(Input::get('q'));

        return view('admin.users.index', compact('users'));
    }

    public function getEdit($userId)
    {
        $user = $this->users->requireById($userId);
        $roles = $this->roles->getAll();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function postEdit($userId)
    {
        $user = $this->users->requireById($userId);

        $user->fill(Input::all());

        if (!Input::has('is_banned')) {
            $user->is_banned = 0;
        }

        if (!$user->isValid()) {
            return $this->redirectBack(['errors' => $user->getErrors()]);
        }

        $this->users->save($user);
        $user->roles = Input::get('roles');

        return $this->redirectAction('Admin\UsersController@getIndex', ['success' => 'The user has been saved.']);
    }

    public function putBanAndDeleteThreads($userId)
    {
        // Ban the user
        $user = $this->users->requireById($userId);
        $user->is_banned = 1;

        $this->users->save($user);

        // Remove all threads by the user
        $this->threads->deleteByAuthorId($userId);

        return $this->redirectAction('Admin\UsersController@getIndex', ['success' => 'The user has been banned and its threads have been removed.']);
    }
}
