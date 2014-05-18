<?php

use Lio\Accounts\UserRepository;
use Lio\Accounts\RoleRepository;

class AdminUsersController extends BaseController
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
        $users = $this->users->getAllPaginated(100);
        $this->renderView('admin.users.index', compact('users'));
    }
}
