<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Plane;
use Database\Seeders\PlaneSeeder;
use PHPUnit\Framework\Attributes\Test;

class PlaneApiControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function canListAllPlanes() 
    {
        $this->seed(PlaneSeeder::class);

        $response = $this->getJson('/api/planes'); // Use the actual URL path

        $response->assertStatus(200)
                 ->assertJsonCount(10); // Assuming PlaneSeeder seeds 10 records
    }

    #[Test]
    public function canCreateAPlane()
    {
        $data = [
            'name' => 'Boeing 747',
            'max_seat' => 416,
        ];

        $response = $this->postJson('/api/planes', $data);

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
        $plane = Plane::factory()->create();

        $response = $this->getJson("/api/planes/{$plane->id}");

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
        $plane = Plane::factory()->create();

        $data = [
            'name' => 'Airbus A380',
            'max_seat' => 853,
        ];

        $response = $this->putJson("/api/planes/{$plane->id}", $data);

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
        $plane = Plane::factory()->create();

        $response = $this->deleteJson("/api/planes/{$plane->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('planes', ['id' => $plane->id]);
    }
}
