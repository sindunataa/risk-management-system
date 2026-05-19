<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $categories = ['Operational', 'Financial', 'Strategic', 'Compliance', 'Technology'];

        foreach ($categories as $cat) {
            \App\Models\RiskCategory::create(['name' => $cat]);
        }
    }
}
