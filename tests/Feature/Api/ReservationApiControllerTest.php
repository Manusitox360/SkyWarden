<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_CanListAllReservations(): void
    {
        $user = User::factory()->user()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');
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
        $admin = User::factory()->admin()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');
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
        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $token,
            'Accept' => 'application/json',])->post(route('ApiStoreReservation'), $data);

        // Assert: Check if the reservation was created successfully
        $response->assertStatus(201);
        $this->assertDatabaseHas('reservations', $data); // Ensure the reservation exists in the database
    }

    public function test_CanShowAReservation(): void
    {
        $user = User::factory()->user()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');

        $user = User::factory()->user()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');
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
        $user = User::factory()->user()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');
        $reservation = Reservation::factory()->create();

        // Prepare updated data
        $updatedData = [
            'status' => false, // Use boolean for status
            'seat_number' => 15,
        ];

        // Act: Send a PUT request to update the reservation
        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $token,
            'Accept' => 'application/json',])->put(route('ApiUpdateReservation', ['id' => $reservation->id]), $updatedData);

        // Assert: Check if the reservation was updated successfully
        $response->assertStatus(200);
        $this->assertDatabaseHas('reservations', $updatedData); // Ensure the updated data exists in the database
    }

    public function test_CanDeleteAReservation(): void
    {
        $user = User::factory()->user()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');
        // Arrange: Create a reservation
        $reservation = Reservation::factory()->create();

        // Act: Send a DELETE request to delete the reservation
        $response = $this->withHeaders([
            'Authorization' => "Bearer" . $token,
            'Accept' => 'application/json',])->delete(route('ApiDestroyReservation', ['id' => $reservation->id]));

        // Assert: Check if the reservation was deleted successfully
        $response->assertStatus(204);
        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]); // Ensure the reservation no longer exists in the database
    }
}
