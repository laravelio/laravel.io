<?php

namespace Lio\ModelFactories;

class InvalidModelException extends \Exception
{
    public static function notRegistered(string $model)
    {
        return new static("The model [$model] is not registered with the current factory.");
    }
}
