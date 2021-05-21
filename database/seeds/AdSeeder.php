<?php

use App\Services\RoleService;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ad;
use App\Models\Role;

/**
 * AdSeeder
 */
class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $roleService = resolve(RoleService::class);
        $roleId = $roleService->getRoleIdByName(Role::AUTHOR_ROLE);
        if (!$roleId) {
            throw new Exception('blabla');
        }

        //dd($roleId);
        factory(User::class, 5)->create()->each(
            function ($user) use ($roleId) {
                $user->update(['role_id' => $roleId]);
                $user->ads()->saveMany(factory(Ad::class, 40)->make());
            }
        );
    }
}
