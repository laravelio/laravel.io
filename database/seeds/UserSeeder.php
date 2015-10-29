<?php

use Illuminate\Database\Seeder;
use Lio\Users\EloquentUser;

class UserSeeder extends Seeder
{
    public function run()
    {
        factory(EloquentUser::class)->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'johndoe',
            'password' => bcrypt('password'),
        ]);
    }
}
