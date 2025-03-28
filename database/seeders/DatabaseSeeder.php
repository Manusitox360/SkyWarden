<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PlaneSeeder;
use Database\Seeders\FlightSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\ReservationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            PlaneSeeder::class,
            UserSeeder::class,
            FlightSeeder::class,
            ReservationSeeder::class,
            LocationSeeder::class,
        ]);
    }
}
