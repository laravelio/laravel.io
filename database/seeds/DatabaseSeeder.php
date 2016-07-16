<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('production')) {
            exit('I just stopped you getting fired. Love Phil');
            // Thanks Phil!
        }

        $this->call(UserSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ThreadSeeder::class);
    }
}
