<?php

use Illuminate\Database\Seeder;
use Lio\Forum\EloquentThread;

class ThreadSeeder extends Seeder
{
    public function run()
    {
        factory(EloquentThread::class, 5)->create();
    }
}
