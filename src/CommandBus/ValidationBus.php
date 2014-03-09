<?php namespace Lio\CommandBus; 

class ValidationBus implements CommandBusInterface
{
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function execute($command)
    {
        $this->bus->execute($command);
    }
} 
