<?php namespace Lio\Contributors;

use Lio\Core\EloquentBaseRepository;

class ContributorRepository extends EloquentBaseRepository
{
    public function __construct(Contributor $model)
    {
        $this->model = $model;
    }
}
