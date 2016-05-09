<?php

use Illuminate\Database\Seeder;
use Lio\ModelFactories\BuildsModels;
use Lio\Users\User;

class UserSeeder extends Seeder
{
    use BuildsModels;

    public function run()
    {
        $this->create(User::class, [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'johndoe',
            'password' => bcrypt('password'),
        ]);
    }
}
