<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AdFactory
 * @package Database\Factories
 */
class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(2);
        $description = $this->faker->sentence(10);
        $price = $this->faker->numberBetween($min = 15000, $max = 600000);
        $phoneNumber = $this->faker->e164PhoneNumber;
        $latitude =$this-> faker->latitude;
        $longitude = $this->faker->longitude;
        $countryCode = $this->faker->countryCode;
        $endDate = $this->faker->dateTimeBetween('now', '+1 years');

        return [
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'phone_number' => $phoneNumber,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'country_code' => $countryCode,
            'end_date' => $endDate,
        ];
    }
}
