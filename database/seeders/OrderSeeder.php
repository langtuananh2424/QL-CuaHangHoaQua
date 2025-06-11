<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Tạo 20 đơn hàng mẫu
        for ($i = 0; $i < 20; $i++) {
            $total_amount = $faker->randomFloat(2, 50000, 500000);
            $discount = $faker->randomFloat(2, 0, 0.3); // Giảm giá từ 0-30%
            $final_amount = $total_amount * (1 - $discount);

            DB::table('orders')->insert([
                'customer_name' => $faker->name,
                'total_amount' => $total_amount,
                'final_amount' => $final_amount,
                'status' => $faker->randomElement(['pending', 'completed', 'cancelled']),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
