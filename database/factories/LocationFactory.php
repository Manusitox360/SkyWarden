<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    protected $model = \App\Models\Location::class;

    public function definition()
    {
        return [
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'airport_code' => $this->faker->unique()->lexify('???'),
        ];
    }
}
