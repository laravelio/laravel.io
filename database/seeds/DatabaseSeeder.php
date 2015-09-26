<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        Model::unguard();

        $this->call(UserSeeder::class);

        Model::reguard();
    }
}
