<?php

use App\Models\Ad;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Database\Seeder;

/**
 * AdSeeder
 */
class AdSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $roleId = RoleService::getRoleIdByName(RoleService::AUTHOR_ROLE);

        factory(User::class, 5)->create()->each(
            function ($user) use ($roleId) {
                $user->update(['role_id' => $roleId]);
                $user->ads()->saveMany(factory(Ad::class, 40)->make());
            }
        );
    }
}
