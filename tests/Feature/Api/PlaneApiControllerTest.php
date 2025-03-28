<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plane;
use Database\Seeders\PlaneSeeder;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaneApiControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function canListAllPlanes() 
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');

        $this->seed(PlaneSeeder::class);

        $response = $this->withHeaders([
            'Authorization' => "Bearer" . $token,
            'Accept' => 'application/json',])->getJson('/api/planes'); // Use the actual URL path

        $response->assertStatus(200)
                 ->assertJsonCount(10); // Assuming PlaneSeeder seeds 10 records
    }

    #[Test]
    public function canCreateAPlane()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');
        $data = [
            'name' => 'Boeing 747',
            'max_seat' => 416,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer" . $token,
            'Accept' => 'application/json',])->postJson('/api/planes', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'name' => 'Boeing 747',
                         'max_seat' => 416,
                     ],
                 ]);

        $this->assertDatabaseHas('planes', [
            'name' => 'Boeing 747',
            'max_seat' => 416,
        ]);
    }

    #[Test]
    public function canShowAPlane()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');
        
        $plane = Plane::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer" . $token,
            'Accept' => 'application/json',])->getJson("/api/planes/{$plane->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $plane->id,
                         'name' => $plane->name,
                         'max_seat' => $plane->max_seat,
                     ],
                 ]);
    }

    #[Test]
    public function canUpdateAPlane()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');
        $plane = Plane::factory()->create();


        $data = [
            'name' => 'Airbus A380',
            'max_seat' => 853,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer" . $token,
            'Accept' => 'application/json',])->putJson("/api/planes/{$plane->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $plane->id,
                         'name' => 'Airbus A380',
                         'max_seat' => 853,
                     ],
                 ]);

        $this->assertDatabaseHas('planes', $data);
    }

    #[Test]
    public function canDeleteAPlane()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post(route('auth.Login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        
        $token = $response->json('access_token');

        $plane = Plane::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer" . $token,
            'Accept' => 'application/json',])->deleteJson("/api/planes/{$plane->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('planes', ['id' => $plane->id]);
    }
}
