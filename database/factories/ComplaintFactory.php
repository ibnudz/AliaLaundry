<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Complaint>
 */
class ComplaintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'user_id' => User::factory(),
            'issue_description' => fake()->sentence(10),
            'complaint_status' => fake()->randomElement(['Pending', 'Processing', 'Resolved']),
            'resolution' => fake()->optional()->sentence(8),
        ];
    }
}
