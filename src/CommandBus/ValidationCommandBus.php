<?php namespace Lio\CommandBus; 

use Illuminate\Container\Container;
use ReflectionException;

class ValidationCommandBus implements CommandBusInterface
{
    private $bus;
    private $inflector;

    public function __construct(CommandBus $bus, Container $container, CommandHandlerNameInflector $inflector)
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
        } catch (ReflectionException $e) {
        }

        if (isset($validator)) {
            $validator->validate($command);
        }
    }
} 
