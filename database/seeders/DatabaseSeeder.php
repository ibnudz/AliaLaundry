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
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'phone' => '08123456789',
            'address' => 'Jl. Laundry No. 1',
        ]);

        User::factory()->create([
            'name' => 'Member',
            'email' => 'member@mail.com',
            'phone' => '08198765432',
            'address' => 'Jl. Laundry No. 2',
        ]);

        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
            OrderSeeder::class,
            OrderDetailSeeder::class,
            ReviewSeeder::class,
            ComplaintSeeder::class,
        ]);
    }
}
