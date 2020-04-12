<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! App::environment('production')) {
            $this->call(UserSeeder::class);
            $this->call(TagSeeder::class);
            $this->call(ThreadSeeder::class);
            $this->call(NotificationSeeder::class);
            $this->call(ArticleSeeder::class);
        }
    }
}
