<?php

namespace Database\Seeders;

use App\Models\Complaint;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Complaint::factory()
            ->count(5)
            ->sequence(
                ['complaint_status' => 'Pending'],
                ['complaint_status' => 'Pending'],
                ['complaint_status' => 'Processing'],
                ['complaint_status' => 'Processing'],
                ['complaint_status' => 'Resolved'],
            )
            ->create();
    }
}
