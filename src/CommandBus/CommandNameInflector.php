<?php namespace Lio\CommandBus;

class CommandNameInflector
{
    public function getHandlerClass($command)
    {
        return str_replace('Command', 'Handler', get_class($command));
    }

    public function getValidatorClass($command)
    {
        return str_replace('Command', 'Validator', get_class($command));
    }
}
