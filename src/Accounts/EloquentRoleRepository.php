<?php namespace Lio\Accounts;

use Lio\Core\EloquentRepository;

class EloquentRoleRepository extends EloquentRepository
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function getRoleList()
    {
        return $this->model->lists('name', 'id');
    }
}
