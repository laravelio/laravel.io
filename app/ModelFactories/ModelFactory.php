<?php

namespace App\ModelFactories;

interface ModelFactory
{
    public function make(string $model, array $attributes = []);
    public function create(string $model, array $attributes = [], int $times = 1);
}
