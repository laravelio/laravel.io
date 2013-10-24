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
            'admin_posts' => 'publish posts',
            'admin_users' => 'manage user roles and accounts',
            'write_posts' => 'write posts',
        ];

        foreach ($roles as $role => $description) {
            Role::create([
                'name'        => $role,
                'description' => $description,
            ]);
        }
    }
}