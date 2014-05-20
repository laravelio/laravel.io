<?php namespace Lio\Bin\Repositories; 

use Illuminate\Database\Eloquent\Model;

interface PasteRepository
{
    /**
     * @param Model $model
     * @return mixed
     */
    public function save(Model $model);

    /**
     * @param $hash
     * @return \Lio\Bin\Entities\Paste
     */
    public function getByHash($hash);

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function delete(Model $model);
} 
