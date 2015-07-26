<?php
namespace Lio\Bin;

use Lio\Core\EloquentRepository;

class PasteRepository extends EloquentRepository
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
        return $this->model->whereRaw('hash = BINARY ?', [$hash])->first();
    }
}
