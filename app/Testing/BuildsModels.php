<?php
namespace Lio\Testing;

use Lio\ModelFactories\ModelFactory;

trait BuildsModels
{
    /**
     * @var ModelFactory
     */
    protected $modelFactory;

    /**
     * @before
     */
    public function setModelFactory()
    {
        $this->modelFactory = $this->app->make(ModelFactory::class);
    }

    /**
     * @after
     */
    public function unsetModelFactory()
    {
        unset($this->modelFactory);
    }

    /**
     * @param string $model
     * @param array $attributes
     * @return object
     */
    public function make($model, array $attributes = [])
    {
        return $this->modelFactory->make($model, $attributes);
    }

    /**
     * @param string $model
     * @param array $attributes
     * @param int $times
     * @return object
     */
    public function create($model, array $attributes = [], $times = 1)
    {
        return $this->modelFactory->create($model, $attributes, $times);
    }
}
