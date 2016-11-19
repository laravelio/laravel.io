<?php

namespace App\Helpers;

trait BuildsModels
{
    public function make(string $model, array $attributes = [])
    {
        return factory($model)->make($attributes);
    }

    public function create(string $model, array $attributes = [], int $times = 1)
    {
        return factory($model, $times)->create($attributes);
    }
}

