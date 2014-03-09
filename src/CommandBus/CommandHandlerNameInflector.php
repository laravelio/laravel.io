<?php namespace Lio\CommandBus;

class CommandHandlerNameInflector
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
