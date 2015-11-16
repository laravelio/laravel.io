<?php
namespace Lio\ModelFactories;

interface ModelFactory
{
    /**
     * @param string $model
     * @param array $attributes
     * @return object
     */
    public function make($model, array $attributes = []);

    /**
     * @param string $model
     * @param array $attributes
     * @param int $times
     * @return object
     */
    public function create($model, array $attributes = [], $times = 1);
}
