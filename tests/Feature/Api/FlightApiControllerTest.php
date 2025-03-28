<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Flight;
use App\Models\Plane;
use App\Models\Location;

class FlightApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_CanListAllFlights(): void
    {
        // Arrange: Create some flights
        Flight::factory()->count(5)->create();

        // Act: Send a GET request to the API endpoint
        $response = $this->get(route('ApiIndexFlights'));

        // Assert: Check if the response is successful and contains the flights
        $response->assertStatus(200);
        $response->assertJsonCount(5); // Ensure 5 flights are returned
    }

    public function test_CanCreateAFlight(): void
    {
        // Arrange: Create a plane and locations
        $plane = Plane::factory()->create();
        $departureLocation = Location::factory()->create();
        $arrivalLocation = Location::factory()->create();

        // Prepare flight data
        $data = [
            'plane_id' => $plane->id,
            'departure_location_id' => $departureLocation->id,
            'arrival_location_id' => $arrivalLocation->id,
            'departure_date' => now()->addDays(5)->toDateTimeString(),
            'arrival_date' => now()->addDays(6)->toDateTimeString(),
            'price' => 500,
            'status' => true,
        ];

        // Act: Send a POST request to create a flight
        $response = $this->post(route('ApiStoreFlights'), $data);

        // Assert: Check if the flight was created successfully
        $response->assertStatus(201);
        $this->assertDatabaseHas('flights', $data); // Ensure the flight exists in the database
    }

    public function test_CanShowAFlight(): void
    {
        // Arrange: Create a flight
        $flight = Flight::factory()->create();

        // Act: Send a GET request to retrieve the flight
        $response = $this->get(route('ApiShowFlights', ['id' => $flight->id]));

        // Assert: Check if the response is successful and contains the flight data
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $flight->id]); // Ensure the flight ID is present in the response
    }
    
    public function test_CanUpdateAFlight(): void
    {
        // Arrange: Create a flight
        $flight = Flight::factory()->create();

        // Prepare updated data
        $updatedData = [
            'price' => 600,
            'status' => false,
        ];

        // Act: Send a PUT request to update the flight
        $response = $this->put(route('ApiUpdateFlights', ['id' => $flight->id]), $updatedData);

        // Assert: Check if the flight was updated successfully
        $response->assertStatus(200);
        $this->assertDatabaseHas('flights', $updatedData); // Ensure the updated data exists in the database
    }

    public function test_CanDeleteAFlight(): void
    {
        // Arrange: Create a flight
        $flight = Flight::factory()->create();

        // Act: Send a DELETE request to delete the flight
        $response = $this->delete(route('ApiDestroyFlights', ['id' => $flight->id]));

        // Assert: Check if the flight was deleted successfully
        $response->assertStatus(200);
        $this->assertDatabaseMissing('flights', ['id' => $flight->id]); // Ensure the flight no longer exists in the database
    }
}
