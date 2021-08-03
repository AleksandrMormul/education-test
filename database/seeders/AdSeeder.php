<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\User;
use App\Services\RoleService;
use Exception;
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

        User::factory()->count(5)->create()->each(
            function ($user) use ($roleId) {
                $user->update(['role_id' => $roleId]);
                $user->ads()->saveMany(Ad::factory()->count(40)->make());
            }
        );
    }
}
