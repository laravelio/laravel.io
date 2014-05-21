<?php

use Lio\Accounts\EloquentMemberRepository;
use Lio\Accounts\EloquentRoleRepository;

class AdminUsersController extends BaseController
{
    private $users;
    private $roles;

    public function __construct(EloquentMemberRepository $users, EloquentRoleRepository $roles)
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
