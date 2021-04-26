<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use Faker\Generator as Faker;

$factory->define(Ad::class, function (Faker $faker) {
    $title = $faker->sentence(2);
    $description = $faker->sentence(10);

    return [
        'title' => $title,
        'description' => $description
    ];
});
