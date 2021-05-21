<?php

use App\Models\Role;
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
        if (Role::whereIn('name', [Role::ADMIN_ROLE, Role::AUTHOR_ROLE, Role::USER_ROLE])->doesntExist()) {
            $roles = [Role::ADMIN_ROLE, Role::AUTHOR_ROLE, Role::USER_ROLE];
            foreach ($roles as $roleName) {
                Role::create([
                    'name' => $roleName
                ]);
            }
        }
    }
}
