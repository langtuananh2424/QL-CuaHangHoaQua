<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FruitFactory extends Factory
{
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 10, 200);
        $isDiscount = $this->faker->boolean(30);
        $oldPrice = $isDiscount ? $price + $this->faker->randomFloat(2, 5, 50) : null;
        return [
            'name' => $this->faker->word(),
            'price' => $price,
            'old_price' => $oldPrice,
            'description' => $this->faker->sentence(),
            'stock' => $this->faker->numberBetween(0, 1000),
            'is_discount' => $isDiscount,
            'is_clean' => $this->faker->boolean(50),
            'image' => $this->faker->randomElement([
                'apple.jpg','orange.jpg','mango.jpg','kiwi.jpg','grape.jpg','banana.jpg','watermelon.jpg','strawberry.jpg','potato.jpg','tomato.jpg','papaya.jpg','carrot.jpg','pepper.jpg','pineapple.jpg'
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
