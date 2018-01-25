<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@developers.mv',
            'username' => 'Admin',
            'password' => bcrypt('itisasecret'),
        ]);
    }
}
