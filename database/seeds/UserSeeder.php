<?php

use App\Helpers\BuildsModels;
use App\Users\User;
use Illuminate\Database\Seeder;

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
