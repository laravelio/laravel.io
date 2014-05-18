<?php namespace Lio\CommandBus;

class CommandNameInflector
{
    public function getHandlerClass($command)
    {
        return str_replace('Request', 'Handler', get_class($command));
    }

    public function getValidatorClass($command)
    {
        return str_replace('Request', 'Validator', get_class($command));
    }
}
