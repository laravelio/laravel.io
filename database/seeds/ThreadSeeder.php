<?php

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    public function run()
    {
        factory(Thread::class, 50)->create(['author_id' => 1]);

        factory(Reply::class)->create(['author_id' => 1, 'replyable_id' => 1]);
        factory(Reply::class)->create(['author_id' => 1, 'replyable_id' => 1]);
        factory(Reply::class)->create(['author_id' => 1, 'replyable_id' => 2]);
    }
}
