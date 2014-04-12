<?php namespace Lio\Github; 

use Lio\Core\EloquentRepository;

class TokenRepository extends EloquentRepository
{
    public function __construct(Token $model)
    {
        $this->model = $model;
    }
} 
