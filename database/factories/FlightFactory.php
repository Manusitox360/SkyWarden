<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    protected $model = \App\Models\Flight::class;

    public function definition()
    {
        return [
            'departure_location_id' => \App\Models\Location::factory(),
            'arrival_location_id' => \App\Models\Location::factory(),
            'plane_id' => \App\Models\Plane::factory(),
            'departure_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'arrival_date' => $this->faker->dateTimeBetween('+1 month', '+2 month'),
            'price' => $this->faker->numberBetween(100, 1000),
            'status' => $this->faker->boolean(),
        ];
    }
}
