<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plane;
use App\Models\Flight;
use App\Models\Location;
use App\Models\Reservation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppModelsTest extends TestCase
{
    use RefreshDatabase;


     /** @test */
public function it_can_create_a_plane_with_flights()
{
    // Create locations first
    $departureLocation = \App\Models\Location::factory()->create();
    $arrivalLocation = \App\Models\Location::factory()->create();

    // Create the plane
    $plane = \App\Models\Plane::create([
        'name' => 'Boeing 747',
        'max_seat' => 350,
    ]);

    // Create a flight associated with the plane and locations
    $flight = \App\Models\Flight::create([
        'departure_location_id' => $departureLocation->id,
        'arrival_location_id' => $arrivalLocation->id,
        'plane_id' => $plane->id,
        'departure_date' => now(),
        'arrival_date' => now()->addHours(2),
        'price' => 500,
        'status' => true,
    ]);

    // Assert the plane's flights relationship contains the created flight
    $this->assertTrue($plane->flights->contains($flight));
}



    /** @test */
    public function it_can_create_and_store_a_user()
    {
        // Arrange: Create a user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Assert: Check the user is in the database
        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
        ]);
    }

    /** @test */
    public function it_can_create_a_location()
    {
        $location = Location::create([
            'city' => 'Paris',
            'country' => 'France',
            'airport_code' => 'CDG',
        ]);

        // Assert: Check if location is in the database
        $this->assertDatabaseHas('locations', [
            'city' => 'Paris',
            'country' => 'France',
            'airport_code' => 'CDG',
        ]);
    }

    /** @test */
   /** @test */
/** @test */
public function it_can_create_a_flight_and_check_relationships()
{
    $location1 = Location::factory()->create();
    $location2 = Location::factory()->create();
    $plane = Plane::factory()->create();

    // Create a flight using the factory
    $flight = Flight::factory()->create([
        'departure_location_id' => $location1->id,
        'arrival_location_id' => $location2->id,
        'plane_id' => $plane->id,
    ]);

    // Assert: Check that the flight was created
    $this->assertDatabaseHas('flights', [
        'departure_location_id' => $location1->id,
        'arrival_location_id' => $location2->id,
        'plane_id' => $plane->id,
    ]);

    // Check relationships
    $this->assertTrue($location1->departingFlights->contains($flight));
    $this->assertTrue($location2->arrivingFlights->contains($flight));
}



    /** @test */
    public function it_can_create_a_reservation_and_check_relationship()
    {
        $user = User::factory()->create();
        $flight = Flight::factory()->create();

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'flight_id' => $flight->id,
            'status' => true,
            'seat_number' => 12,
        ]);

        // Assert: Check reservation is in the database
        $this->assertDatabaseHas('reservations', [
            'seat_number' => 12,
        ]);

        // Check relationships
        $this->assertTrue($user->reservations->contains($reservation));
        $this->assertTrue($flight->reservations->contains($reservation));
    }

    /** @test */
    public function it_can_update_a_reservation()
    {
        $reservation = Reservation::factory()->create([
            'status' => true,
            'seat_number' => 12,
        ]);

        // Update the reservation
        $reservation->update([
            'status' => false,
            'seat_number' => 15,
        ]);

        // Assert: Check the reservation was updated
        $this->assertDatabaseHas('reservations', [
            'seat_number' => 15,
            'status' => false,
        ]);
    }

    /** @test */
    public function it_can_delete_a_reservation()
    {
        $reservation = Reservation::factory()->create();

        // Delete the reservation
        $reservation->delete();

        // Assert: Check the reservation no longer exists in the database
        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
        ]);
    }
}

