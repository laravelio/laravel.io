<?php namespace Lio\Core;

use Lio\Core\Exceptions\EntityNotFoundException;

class EloquentBaseRepository
{
    protected $model;

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllPaginated($count)
    {
        return $this->model->paginate($count);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function requireById($id)
    {
        $model = $this->getById($id);

        if ( ! $model) {
            throw new EntityNotFoundException;
        }

        return $model;
    }

    public function getNew($attributes = array())
    {
        return $this->model->newInstance($attributes);
    }

    public function store($data)
    {
        if ($data instanceOf \Eloquent) {
            $this->storeEloquentModel($data);
        } elseif (is_array($data)) {
            $this->storeArray($data);
        }
    }

    public function delete($model)
    {
        $model->delete();
    }

    protected function storeEloquentModel($model)
    {
        if ($model->getDirty()) {
            $model->save();
        } else {
            $model->touch();
        }
    }

    protected function storeArray($data)
    {
        $model = $this->getNew($data);
        $this->storeEloquentModel($model);
    }
}