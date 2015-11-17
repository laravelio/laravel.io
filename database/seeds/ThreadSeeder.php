<?php

use Lio\Forum\Thread;

class ThreadSeeder extends Seeder
{
    public function run()
    {
        $this->create(Thread::class, [], 5);
    }
}
