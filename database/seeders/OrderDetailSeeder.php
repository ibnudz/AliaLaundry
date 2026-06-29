<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            OrderDetail::factory()
                ->count(fake()->numberBetween(1, 4))
                ->create([
                    'order_id' => $order->id,
                ]);
        }
    }
}
