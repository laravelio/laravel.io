<?php namespace Lio\Accounts;

use Lio\Core\EloquentBaseRepository;

class RoleRepository extends EloquentBaseRepository
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }
}
