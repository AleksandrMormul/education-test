<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ad;

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
        factory(User::class, 5)->create()->each(
            function ($user) {
                $user->ads()->saveMany(factory(Ad::class, 40)->make());
            }
        )->toArray();
    }
}
