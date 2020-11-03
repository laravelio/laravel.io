<?php

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    public function run()
    {
        Thread::factory()->count(50)->create(['author_id' => 1]);

        Reply::factory()->create(['author_id' => 1, 'replyable_id' => 1]);
        Reply::factory()->create(['author_id' => 1, 'replyable_id' => 1]);
        Reply::factory()->create(['author_id' => 1, 'replyable_id' => 2]);
    }
}
