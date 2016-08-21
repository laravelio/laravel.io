<?php

use App\Forum\Topics\Topic;
use App\ModelFactories\BuildsModels;
use Illuminate\Database\Seeder;

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
