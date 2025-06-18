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
            ['name' => 'Táo', 'type' => 'apple', 'image' => 'tao.jpg'],
            ['name' => 'Cam', 'type' => 'orange', 'image' => 'cam.jpg'],
            ['name' => 'Xoài', 'type' => 'mango', 'image' => 'xoai.jpg'],
            ['name' => 'Chuối', 'type' => 'banana', 'image' => 'chuoi.jpg'],
            ['name' => 'Dưa hấu', 'type' => 'watermelon', 'image' => 'duahau.jpg'],
            ['name' => 'Dứa', 'type' => 'pineapple', 'image' => 'dua.jpg'],
            ['name' => 'Lê', 'type' => 'pear', 'image' => 'le.jpg'],
            ['name' => 'Nho', 'type' => 'grape', 'image' => 'nho.jpg'],
            ['name' => 'Dâu tây', 'type' => 'strawberry', 'image' => 'dautay.jpg'],
            ['name' => 'Đu đủ', 'type' => 'papaya', 'image' => 'dudu.jpg'],
            ['name' => 'Kiwi', 'type' => 'kiwi', 'image' => 'kiwi.jpg'],
            ['name' => 'Mận', 'type' => 'plum', 'image' => 'man.jpg'],
            ['name' => 'Mít', 'type' => 'jackfruit', 'image' => 'mit.jpg'],
            ['name' => 'Sầu riêng', 'type' => 'durian', 'image' => 'saurieng.jpg'],
            ['name' => 'Vải', 'type' => 'lychee', 'image' => 'vai.jpg'],
            ['name' => 'Nhãn', 'type' => 'longan', 'image' => 'nhan.jpg'],
        ];

        foreach ($fruits as $fruit) {
            Fruit::create([
                'name' => $fruit['name'],
                'type' => $fruit['type'],
                'price' => $faker->randomFloat(2, 10000, 200000),
                'stock' => $faker->numberBetween(10, 100),
                'image_url' => '/images/fruits/' . $fruit['image'],
                'is_on_sale' => $faker->boolean(30),
                'is_premium' => $faker->boolean(20),
                'is_organic' => $faker->boolean(25),
            ]);
        }
    }
}
