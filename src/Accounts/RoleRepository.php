<?php namespace Lio\Accounts;

use Illuminate\Database\Eloquent\Model;

interface RoleRepository
{
    public function getRoleList();
    public function save(Model $model);
}
