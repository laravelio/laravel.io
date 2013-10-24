<?php

use Lio\Accounts\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (User::count() == 0) {
            $this->createUsers();
        }
    }

    private function createUsers()
    {
        User::create([
            'id'         => 1,
            'email'      => 'shawn@heybigname.com',
            'name'       => 'ShawnMcCool',
            'github_url' => 'https://github.com/ShawnMcCool',
            'image_url'  => 'https://2.gravatar.com/avatar/c7d7ea7ed7cdf742ebc2c9445b9928c3?d=https%3A%2F%2Fidenticons.github.com%2F5acd34b4fee131776d30ebf26350f99e.png',
            'created_at' => '2013-09-22 18:01:57',
            'updated_at' => '2013-09-23 15:25:16',
        ]);
    }
}