<?php namespace Lio\Bin\Repositories;

use Lio\Bin\Entities\Paste;
use Lio\Core\EloquentRepository;

class EloquentPasteRepository extends EloquentRepository
{
    public function __construct(Paste $model)
    {
        $this->model = $model;
    }

    public function getRecentPaginated($perPage = 20)
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getByHash($hash)
    {
        return $this->model->whereR('hash', '=', $hash)->first();
    }
}
