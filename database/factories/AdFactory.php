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
    $countryCode = $faker->countryCode;
    $endDate = $faker->dateTimeBetween('now', '+1 years');

    return [
        'title' => $title,
        'description' => $description,
        'phone_number' => $phoneNumber,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'country_code' => $countryCode,
        'end_date' => $endDate,
    ];
});
