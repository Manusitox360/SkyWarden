<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = \App\Models\Reservation::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory()->create()->id, // Generate a user ID using the UserFactory
            'flight_id' => \App\Models\Flight::factory(), // Correctly use the FlightFactory
            'status' => $this->faker->boolean(),
            'seat_number' => $this->faker->numberBetween(1, 200),
        ];
    }
}
