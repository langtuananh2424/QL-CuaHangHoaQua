<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
