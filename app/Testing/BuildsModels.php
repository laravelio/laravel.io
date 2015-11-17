<?php
namespace Lio\Testing;

use Lio\ModelFactories\ModelFactory;

trait BuildsModels
{
    use \Lio\ModelFactories\BuildsModels;

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
}
