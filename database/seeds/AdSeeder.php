<?php

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
     */
    public function run()
    {
        $roleId = Role::whereRole('author')->first()->id;
        factory(User::class, 5)->create()->each(
            function ($user) use ($roleId) {
                $user->update(['role_id' => $roleId]);
                $user->ads()->saveMany(factory(Ad::class, 40)->make());
            }
        );
    }
}
