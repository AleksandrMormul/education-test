<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\RoleService;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    public const ADMIN_USER_NAME = 'admin';
    public const ADMIN_USER_EMAIL = 'admin@admin.com';
    public const ADMIN_USER_PASSWORD = 'admin';

    /**
     * Run the database seeders.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        if (User::where('email', self::ADMIN_USER_EMAIL)->doesntExist()) {

            $roleIdAdmin = RoleService::getRoleIdByName(RoleService::ADMIN_ROLE);
            $roleIdUser = RoleService::getRoleIdByName(RoleService::USER_ROLE);
            $roleIdAuthor = RoleService::getRoleIdByName(RoleService::AUTHOR_ROLE);
            User::create(
                [
                    'name' => self::ADMIN_USER_NAME,
                    'email' => self::ADMIN_USER_EMAIL,
                    'role_id' => $roleIdAdmin,
                    'password' => Hash::make(self::ADMIN_USER_PASSWORD)
                ]
            );

            User::factory()->count(2)->create(['role_id' => $roleIdUser]);
            User::factory()->count(2)->create(['role_id' => $roleIdAuthor]);
        }
    }
}
