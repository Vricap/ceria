<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Upstream User
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '123', // usually hashed, but keeping upstream logic
            'role' => 'super_admin',
        ]);

        $this->call([
            LocationSeeder::class,
            CategorySeeder::class,
            SiteSeeder::class,
            PropertySeeder::class,
        ]);
    }
}
