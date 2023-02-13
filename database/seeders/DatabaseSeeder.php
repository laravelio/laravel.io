<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! App::environment('production')) {
            $this->call(UserSeeder::class);
            $this->call(TagSeeder::class);
            $this->call(ReplySeeder::class);
            $this->call(NotificationSeeder::class);
            $this->call(LikeSeeder::class);
        }
    }
}
