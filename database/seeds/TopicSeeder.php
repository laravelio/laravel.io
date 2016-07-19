<?php

use Illuminate\Database\Seeder;
use Lio\Forum\Topics\Topic;
use Lio\ModelFactories\BuildsModels;

class TopicSeeder extends Seeder
{
    use BuildsModels;

    public function run()
    {
        $this->create(Topic::class, ['name' => 'Laravel']);
        $this->create(Topic::class, ['name' => 'Lumen']);
        $this->create(Topic::class, ['name' => 'Spark']);
    }
}
