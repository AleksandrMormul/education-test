<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use Faker\Generator as Faker;

$factory->define(Ad::class, function (Faker $faker) {
    $title = $faker->sentence(2);
    $description = $faker->sentence(10);
    $phoneNumber = $faker->e164PhoneNumber;
    $latitude = $faker->latitude;
    $longitude = $faker->longitude;
    $country = $faker->countryCode;

    return [
        'title' => $title,
        'description' => $description,
        'phone_number' => $phoneNumber,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'country' => $country
    ];
});
