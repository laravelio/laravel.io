<?php namespace Lio\CommandBus;

interface Handler
{
    public function handle($command);
}
