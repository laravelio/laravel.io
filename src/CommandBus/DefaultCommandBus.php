<?php namespace Lio\CommandBus;

use Illuminate\Container\Container;

class DefaultCommandBus implements CommandBus
{
    private $container;
    private $inflector;

    public function __construct(Container $container, CommandNameInflector $inflector)
    {
        $this->container = $container;
        $this->inflector = $inflector;
    }

    public function execute($command)
    {
        return $this->getHandler($command)->handle($command);
    }

    private function getHandler($command)
    {
        return $this->container->make($this->inflector->getHandlerClass($command));
    }
}
