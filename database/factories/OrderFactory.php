<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'total_amount' => $this->faker->randomFloat(2, 10, 1000),
            'final_amount' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
