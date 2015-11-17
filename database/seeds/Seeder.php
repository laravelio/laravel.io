<?php

use Illuminate\Database\Seeder as LaravelSeeder;
use Lio\ModelFactories\BuildsModels;
use Lio\ModelFactories\ModelFactory;

class Seeder extends LaravelSeeder
{
    use BuildsModels;

    public function __construct(ModelFactory $modelFactory)
    {
        $this->modelFactory = $modelFactory;
    }
}
