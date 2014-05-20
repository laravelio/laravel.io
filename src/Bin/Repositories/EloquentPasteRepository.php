<?php namespace Lio\Bin\Repositories;

use Illuminate\Database\Eloquent\Model;
use Lio\Bin\Entities\Paste;
use Lio\Core\EloquentRepository;

class EloquentPasteRepository extends EloquentRepository implements PasteRepository
{
    public function __construct(Paste $model)
    {
        $this->model = $model;
    }

    public function getByHash($hash)
    {
        return $this->model->whereRaw('BINARY hash = ?', [$hash])->first();
    }

    public function save(Model $model)
    {
        $model->save();
        $model->hash = \Hashids::encrypt($model->id);
        $model->save();
    }
}
