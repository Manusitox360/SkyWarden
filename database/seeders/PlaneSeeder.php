<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plane;

class PlaneSeeder extends Seeder
{
   
    public function run(): void
    {
        Plane::factory()->count(10)->create();
    }
}
