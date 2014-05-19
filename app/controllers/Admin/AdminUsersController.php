<?php

use Lio\Accounts\EloquentMemberRepository;
use Lio\Accounts\RoleRepository;

class AdminUsersController extends BaseController
{
    private $users;
    private $roles;

    public function __construct(EloquentMemberRepository $users, RoleRepository $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function getIndex()
    {
        $users = $this->users->getAllPaginated(100);
        $this->render('admin.users.index', compact('users'));
    }
}
