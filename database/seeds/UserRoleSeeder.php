<?php

use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleSeeder
 */
class UserRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::whereIn('name', [RoleService::ADMIN_ROLE, RoleService::AUTHOR_ROLE, RoleService::USER_ROLE])->doesntExist()) {
            $roles = [RoleService::ADMIN_ROLE, RoleService::AUTHOR_ROLE, RoleService::USER_ROLE];

            foreach ($roles as $roleName) {
                Role::create([
                    'name' => $roleName
                ]);
            }
        }
    }
}
