<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'johndoe',
            'github_username' => 'driesvints',
            'password' => bcrypt('password'),
            'type' => User::ADMIN,
        ]);
    }
}
