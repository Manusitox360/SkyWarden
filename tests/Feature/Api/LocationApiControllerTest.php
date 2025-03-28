<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Location;

class LocationApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_CanListAllLocations(): void
    {
        // Arrange: Create some locations
        Location::factory()->count(5)->create();

        // Act: Send a GET request to the API endpoint using the route name
        $response = $this->get(route('ApiIndexLocations'));

        // Assert: Check if the response is successful and contains the locations
        $response->assertStatus(200);
        $response->assertJsonCount(5); // Ensure 5 locations are returned
    }

    public function test_CanCreateALocation(): void
    {
        // Arrange: Prepare location data
        $data = [
            'city' => 'New York',
            'country' => 'USA',
            'airport_code' => 'JFK',
        ];

        // Act: Send a POST request to create a location using the route name
        $response = $this->post(route('ApiStoreLocation'), $data);

        // Assert: Check if the location was created successfully
        $response->assertStatus(201);
        $this->assertDatabaseHas('locations', $data); // Ensure the location exists in the database
    }

    public function test_canShowALocation(): void
    {
        // Arrange: Create a location
        $location = Location::factory()->create();

        // Act: Send a GET request to retrieve the location using the route name
        $response = $this->get(route('ApiShowLocation', ['id' => $location->id]));

        // Assert: Check if the response is successful and contains the location data
        $response->assertStatus(200);
        $response->assertJsonFragment($location->toArray()); // Ensure the location data is present in the response
    }

    public function test_CanUpdateALocation(): void
    {
        // Arrange: Create a location
        $location = Location::factory()->create();

        // Prepare updated data
        $updatedData = [
            'city' => 'Los Angeles',
            'country' => 'USA',
            'airport_code' => 'LAX',
        ];

        // Act: Send a PUT request to update the location using the route name
        $response = $this->put(route('ApiUpdateLocation', ['id' => $location->id]), $updatedData);

        // Assert: Check if the location was updated successfully
        $response->assertStatus(200);
        $this->assertDatabaseHas('locations', $updatedData); // Ensure the updated data exists in the database
    }

    public function test_CanDeleteALocation(): void
    {
        // Arrange: Create a location
        $location = Location::factory()->create();

        // Act: Send a DELETE request to delete the location using the route name
        $response = $this->delete(route('ApiDestroyLocation', ['id' => $location->id]));

        // Assert: Check if the location was deleted successfully
        $response->assertStatus(204);
        $this->assertDatabaseMissing('locations', ['id' => $location->id]); // Ensure the location no longer exists in the database
    }
}
