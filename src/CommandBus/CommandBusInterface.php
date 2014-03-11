<?php namespace Lio\CommandBus; 

interface CommandBusInterface
{
    public function execute($command);
} 
