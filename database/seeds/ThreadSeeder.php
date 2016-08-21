<?php

use App\Forum\Thread;
use App\ModelFactories\BuildsModels;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    use BuildsModels;

    public function run()
    {
        $this->create(Thread::class, ['author_id' => 1], 50);
    }
}
