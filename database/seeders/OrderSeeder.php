<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->count(10)
            ->sequence(
                ['laundry_status' => 'Pending Confirmation', 'payment_status' => 'Unpaid'],
                ['laundry_status' => 'Queued', 'payment_status' => 'Unpaid'],
                ['laundry_status' => 'Washing', 'payment_status' => 'Unpaid'],
                ['laundry_status' => 'Ironing', 'payment_status' => 'Unpaid'],
                ['laundry_status' => 'Completed', 'payment_status' => 'Unpaid'],
                ['laundry_status' => 'Completed', 'payment_status' => 'Paid'],
                ['laundry_status' => 'Picked Up', 'payment_status' => 'Paid'],
                ['laundry_status' => 'Pending Confirmation', 'payment_status' => 'Unpaid'],
                ['laundry_status' => 'Queued', 'payment_status' => 'Unpaid'],
                ['laundry_status' => 'Completed', 'payment_status' => 'Paid'],
            )
            ->create();
    }
}
