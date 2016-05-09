<?php
namespace Lio\ModelFactories;

trait BuildsModels
{
    /**
     * @param string $model
     * @param array $attributes
     * @return object
     */
    public function make($model, array $attributes = [])
    {
        return app(ModelFactory::class)->make($model, $attributes);
    }

    /**
     * @param string $model
     * @param array $attributes
     * @param int $times
     * @return object
     */
    public function create($model, array $attributes = [], $times = 1)
    {
        return app(ModelFactory::class)->create($model, $attributes, $times);
    }
}

