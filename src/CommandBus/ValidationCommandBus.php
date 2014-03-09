<?php namespace Lio\CommandBus; 

use Illuminate\Container\Container;

class ValidationCommandBus implements CommandBusInterface
{
    private $bus;
    private $inflector;

    public function __construct(CommandBus $bus, Container $container, CommandHandlerNameInflector $inflector)
    {
        $this->bus = $bus;
        $this->inflector = $inflector;
    }

    public function execute($command)
    {
        $this->validate($command);
        $this->bus->execute($command);
    }

    private function validate($command)
    {
        $validatorClass = $this->inflector->getValidatorClass($command);
        $this->container->make($validatorClass)->validate();
    }
} 
