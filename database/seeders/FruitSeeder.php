<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Fruit;

class FruitSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $fruits = [
            ['name' => 'Táo', 'type' => 'apple'],
            ['name' => 'Cam', 'type' => 'orange'],
            ['name' => 'Xoài', 'type' => 'mango'],
            ['name' => 'Chuối', 'type' => 'banana'],
            ['name' => 'Dưa hấu', 'type' => 'watermelon'],
            ['name' => 'Dứa', 'type' => 'pineapple'],
            ['name' => 'Lê', 'type' => 'pear'],
            ['name' => 'Nho', 'type' => 'grape'],
            ['name' => 'Dâu tây', 'type' => 'strawberry'],
            ['name' => 'Đu đủ', 'type' => 'papaya'],
            ['name' => 'Kiwi', 'type' => 'kiwi'],
            ['name' => 'Mận', 'type' => 'plum'],
            ['name' => 'Mít', 'type' => 'jackfruit'],
            ['name' => 'Sầu riêng', 'type' => 'durian'],
            ['name' => 'Vải', 'type' => 'lychee'],
            ['name' => 'Nhãn', 'type' => 'longan'],
        ];

        foreach ($fruits as $fruit) {
            Fruit::create([
                'name' => $fruit['name'],
                'type' => $fruit['type'],
                'price' => $faker->randomFloat(2, 10000, 200000),
                'stock' => $faker->numberBetween(10, 100),
                'image_url' => $faker->imageUrl(640, 480, 'fruit'),
            ]);
        }
    }
}
