<?php namesapce Lio\Accounts;

use Lio\Core\EloquentBaseRepository;

class RoleRepository extends EloquentBaseRepository {

    public function __construct(Role $role)
    {
        $this->hasModel($role);
    }

}