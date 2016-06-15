<?php

namespace Lio\ModelFactories;

trait BuildsModels
{
    public function make(string $model, array $attributes = [])
    {
        return app(ModelFactory::class)->make($model, $attributes);
    }

    public function create(string $model, array $attributes = [], int $times = 1)
    {
        return app(ModelFactory::class)->create($model, $attributes, $times);
    }
}

