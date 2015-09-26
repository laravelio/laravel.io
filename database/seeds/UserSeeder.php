<?php

use Illuminate\Database\Seeder;
use Lio\Users\User;

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
            'email' => 'account@account.com',
            'name' => 'Big Ole User Name',
        ]);
    }
}
