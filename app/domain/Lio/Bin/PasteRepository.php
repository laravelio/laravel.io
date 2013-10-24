<?php namespace Lio\Bin;

use Lio\Core\EloquentBaseRepository;

class PasteRepository extends EloquentBaseRepository
{
    public function __construct(Paste $model)
    {
        $this->model = $model;
    }

    public function getRecentPaginated($perPage = 20)
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
