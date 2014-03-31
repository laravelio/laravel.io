<?php namespace Lio\CommandBus; 

use Illuminate\Container\Container;
use ReflectionException;

class ValidationCommandBus implements CommandBus
{
    private $bus;
    private $container;
    private $inflector;

    public function __construct(DefaultCommandBus $bus, Container $container, CommandNameInflector $inflector)
    {
        $this->bus = $bus;
        $this->container = $container;
        $this->inflector = $inflector;
    }

    public function execute($command)
    {
        $this->validate($command);
        return $this->bus->execute($command);
    }

    private function validate($command)
    {
        $validatorClass = $this->inflector->getValidatorClass($command);
        try {
            $validator = $this->container->make($validatorClass);
            $validator->validate($command);
        } catch (ReflectionException $e) {}
    }
} 
