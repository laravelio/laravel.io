<?php

use Lio\Users\User;

class UserSeeder extends Seeder
{
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
