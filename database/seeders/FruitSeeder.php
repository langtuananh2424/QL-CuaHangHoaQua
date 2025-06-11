<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FruitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Danh sách các loại trái cây phổ biến
        $fruits = [
            'Táo', 'Chuối', 'Cam', 'Nho', 'Dưa hấu', 'Dứa', 'Xoài', 'Đu đủ',
            'Dâu tây', 'Kiwi', 'Lê', 'Mận', 'Mít', 'Sầu riêng', 'Vải', 'Nhãn'
        ];

        foreach ($fruits as $fruit) {
            DB::table('fruits')->insert([
                'name' => $fruit,
                'price' => $faker->randomFloat(2, 10000, 200000),
                'stock' => $faker->numberBetween(10, 100),
                'image_url' => $faker->imageUrl(640, 480, 'fruit'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
