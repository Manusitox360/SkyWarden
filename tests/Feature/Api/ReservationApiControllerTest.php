<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Flight;

class ReservationApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_CanListAllReservations(): void
    {
        // Arrange: Create some reservations
        Reservation::factory()->count(5)->create();

        // Act: Send a GET request to the API endpoint
        $response = $this->get(route('ApiIndexReservations'));

        // Assert: Check if the response is successful and contains the reservations
        $response->assertStatus(200);
        $response->assertJsonCount(5); // Ensure 5 reservations are returned
    }

    public function test_CanCreateAReservation(): void
    {
        // Arrange: Create a user and a flight
        $user = User::factory()->create();
        $flight = Flight::factory()->create();

        // Prepare reservation data
        $data = [
            'user_id' => $user->id,
            'flight_id' => $flight->id,
            'status' => true, // Use boolean for status
            'seat_number' => 12,
        ];

        // Act: Send a POST request to create a reservation
        $response = $this->post(route('ApiStoreReservation'), $data);

        // Assert: Check if the reservation was created successfully
        $response->assertStatus(201);
        $this->assertDatabaseHas('reservations', $data); // Ensure the reservation exists in the database
    }

    public function test_CanShowAReservation(): void
    {
        // Arrange: Create a reservation
        $reservation = Reservation::factory()->create();

        // Act: Send a GET request to retrieve the reservation
        $response = $this->get(route('ApiShowReservation', ['id' => $reservation->id]));

        // Assert: Check if the response is successful and contains the reservation
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $reservation->id]); // Ensure the reservation is returned
    }
    
    public function test_CanUpdateAReservation(): void
    {
        // Arrange: Create a reservation
        $reservation = Reservation::factory()->create();

        // Prepare updated data
        $updatedData = [
            'status' => false, // Use boolean for status
            'seat_number' => 15,
        ];

        // Act: Send a PUT request to update the reservation
        $response = $this->put(route('ApiUpdateReservation', ['id' => $reservation->id]), $updatedData);

        // Assert: Check if the reservation was updated successfully
        $response->assertStatus(200);
        $this->assertDatabaseHas('reservations', $updatedData); // Ensure the updated data exists in the database
    }

    public function test_CanDeleteAReservation(): void
    {
        // Arrange: Create a reservation
        $reservation = Reservation::factory()->create();

        // Act: Send a DELETE request to delete the reservation
        $response = $this->delete(route('ApiDestroyReservation', ['id' => $reservation->id]));

        // Assert: Check if the reservation was deleted successfully
        $response->assertStatus(204);
        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]); // Ensure the reservation no longer exists in the database
    }
}
