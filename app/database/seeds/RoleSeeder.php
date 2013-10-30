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
            'admin_articles' => 'manage articles',
            'admin_forum'    => 'manage the forum',
            'admin_users'    => 'manage user roles and accounts',
        ];

        foreach ($roles as $role => $description) {
            Role::create([
                'name'        => $role,
                'description' => $description,
            ]);
        }
    }
}