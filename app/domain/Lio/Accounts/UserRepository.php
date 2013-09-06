<?php namesapce Lio\Accounts;

use Lio\Core\EloquentBaseRepository;

class UserRepository extends EloquentBaseRepository {

    public function __construct(User $user)
    {
        $this->hasModel($user);
    }

}