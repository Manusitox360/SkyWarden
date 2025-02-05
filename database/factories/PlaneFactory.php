<?php

namespace Database\Factories;

use App\Models\Plane;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaneFactory extends Factory
{
    protected $model = Plane::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'max_seat' => $this->faker->numberBetween(50, 200),
        ];
    }
}
