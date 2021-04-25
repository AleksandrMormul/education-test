<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    const ADMIN_USER_NAME = 'admin';
    const ADMIN_USER_EMAIL = 'admin@admin.com';
    const ADMIN_USER_PASSWORD = 'admin';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::where('email', self::ADMIN_USER_EMAIL)->doesntExist()) {
            User::create(
                [
                    'name' => self::ADMIN_USER_NAME,
                    'email' => self::ADMIN_USER_EMAIL,
                    'password' => Hash::make(self::ADMIN_USER_PASSWORD)
                ]
            );
            factory(User::class, 2)->create();
        }
    }
}
