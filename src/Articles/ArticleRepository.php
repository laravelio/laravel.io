<?php namespace Lio\Articles; 

use Illuminate\Database\Eloquent\Model;

interface ArticleRepository
{
    public function save(Model $model);
} 
