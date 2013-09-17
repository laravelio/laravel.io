<?php namespace Controllers\Admin;

use Lio\Accounts\UserRepository;
use Lio\Accounts\RoleRepository;

use Controllers\BaseController;

class UsersController extends BaseController
{
    private $users;
    private $roles;

    public function __construct(UserRepository $users, RoleRepository $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function getIndex()
    {
        $users = $this->users->getAll();

        $this->view('admin.users.index', compact('users'));
    }

    public function getEdit($user)
    {
        $this->view('users.edit', compact('user'));
    }

    public function postEdit($user)
    {
        die('posted');
    }
}