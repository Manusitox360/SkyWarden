<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create 2 regular users
        User::factory()->count(2)->create([
            'role' => 'user',
        ]);

        // Create 1 admin user
        User::factory()->admin()->create();
    }
}
