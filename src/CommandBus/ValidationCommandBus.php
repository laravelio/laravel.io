<?php namespace Lio\CommandBus; 

use Illuminate\Container\Container;

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
        } catch (\Exception $e) {
            throw new CommandValidatorNotFoundException('Validator not found for command, "' . get_class($command) . '". Expected: ' . $this->inflector->getValidatorClass($command));
        }

        $validator->validate($command);
    }
} 
