<?php

use Illuminate\Database\Seeder;
use Lio\Forum\Thread;
use Lio\ModelFactories\BuildsModels;

class ThreadSeeder extends Seeder
{
    use BuildsModels;
    
    public function run()
    {
        $this->create(Thread::class, [], 50);
    }
}
