<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleSeeder
 */
class UserRoleSeeder extends Seeder
{
    public const ADMIN_ROLE = 'admin';
    public const USER_ROLE = 'user';
    public const AUTHOR_ROLE = 'author';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::whereIn('role', [self::ADMIN_ROLE, self::AUTHOR_ROLE, self::USER_ROLE])->doesntExist()) {
            $roles = [self::ADMIN_ROLE, self::AUTHOR_ROLE, self::USER_ROLE];
            foreach ($roles as $roleName) {
                Role::create([
                    'role' => $roleName
                ]);
            }
        }
    }
}
