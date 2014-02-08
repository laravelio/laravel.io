<?php

use Lio\Accounts\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        if (Role::count() == 0) {
            $this->createRoles();
        }
    }

    private function createRoles()
    {
        $roles = [
            'manage_articles' => 'manage articles',
            'manage_forum'    => 'manage the forum',
            'manage_users'    => 'manage user roles and accounts',
        ];

        foreach ($roles as $role => $description) {
            Role::create([
                'name'        => $role,
                'description' => $description,
            ]);
        }
    }
}
