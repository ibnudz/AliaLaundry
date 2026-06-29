<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => 'INV-'.now()->format('Ymd').'-'.strtoupper(Str::random(8)),
            'user_id' => User::factory(),
            'order_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'estimated_finish_at' => fake()->optional()->dateTimeBetween('now', '+1 week'),
            'laundry_status' => fake()->randomElement([
                'Pending Confirmation', 'Queued', 'Washing', 'Ironing', 'Completed', 'Picked Up',
            ]),
            'payment_status' => fake()->randomElement(['Unpaid', 'Paid']),
            'total_price' => 0,
            'customer_note' => fake()->optional()->sentence(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'laundry_status' => 'Pending Confirmation',
            'payment_status' => 'Unpaid',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'laundry_status' => 'Completed',
            'payment_status' => 'Paid',
        ]);
    }
}
