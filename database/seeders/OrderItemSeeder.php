<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy tất cả order_id và fruit_id
        $orderIds = DB::table('orders')->pluck('id')->toArray();
        $fruitIds = DB::table('fruits')->pluck('id')->toArray();

        // Tạo order items cho mỗi đơn hàng
        foreach ($orderIds as $orderId) {
            // Mỗi đơn hàng có 1-5 sản phẩm
            $numberOfItems = $faker->numberBetween(1, 5);

            for ($i = 0; $i < $numberOfItems; $i++) {
                $fruitId = $faker->randomElement($fruitIds);
                $quantity = $faker->numberBetween(1, 10);

                // Lấy giá của trái cây
                $fruit = DB::table('fruits')->where('id', $fruitId)->first();
                $price = $fruit->price;

                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'fruit_id' => $fruitId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
